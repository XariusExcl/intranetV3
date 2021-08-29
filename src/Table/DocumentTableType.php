<?php
/*
 * Copyright (c) 2021. | David Annebicque | IUT de Troyes  - All Rights Reserved
 * @file /Users/davidannebicque/htdocs/intranetV3/src/Table/DocumentTableType.php
 * @author davidannebicque
 * @project intranetV3
 * @lastUpdate 29/08/2021 14:38
 */

namespace App\Table;

use App\Components\Table\Adapter\EntityAdapter;
use App\Components\Table\Column\DateColumnType;
use App\Components\Table\Column\PropertyColumnType;
use App\Components\Table\Column\WidgetColumnType;
use App\Components\Table\TableBuilder;
use App\Components\Table\TableType;
use App\Components\Widget\Type\ButtonDropdownType;
use App\Components\Widget\Type\LinkType;
use App\Components\Widget\Type\RowDeleteLinkType;
use App\Components\Widget\Type\RowDuplicateLinkType;
use App\Components\Widget\Type\RowEditLinkType;
use App\Components\Widget\Type\RowShowLinkType;
use App\Components\Widget\WidgetBuilder;
use App\Table\ColumnType\CategorieArticleColumnType;
use App\Table\ColumnType\SemestreColumnType;
use App\Entity\Annee;
use App\Entity\Departement;
use App\Entity\Diplome;
use App\Entity\Document;
use App\Entity\Semestre;
use App\Form\Type\SearchType;
use Doctrine\ORM\QueryBuilder;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;

class DocumentTableType extends TableType
{
    private ?Departement $departement;
    private CsrfTokenManagerInterface $csrfToken;

    public function __construct(CsrfTokenManagerInterface $csrfToken)
    {
        $this->csrfToken = $csrfToken;
    }

    public function buildTable(TableBuilder $builder, array $options): void
    {
        $this->departement = $options['departement'];

        $builder->addFilter('search', SearchType::class);
//        $builder->addFilter('from', DatepickerType::class, [
//            'input_prefix_text' => 'Du',
//        ]);
//        $builder->addFilter('to', DatepickerType::class, [
//            'input_prefix_text' => 'Au',
//        ]);

//        // Export button (use to export data)
        $builder->addWidget('export', ButtonDropdownType::class, [
            'icon' => 'fas fa-download',
            'attr' => ['data-toggle' => 'dropdown'],
            'build' => function(WidgetBuilder $builder) {
                $builder->add('pdf', LinkType::class, [
                    'route' => 'administration_document_export',
                    'route_params' => ['_format' => 'pdf'],
                ]);
                $builder->add('csv', LinkType::class, [
                    'route' => 'administration_document_export',
                    'route_params' => ['_format' => 'csv'],
                ]);
                $builder->add('excel', LinkType::class, [
                    'route' => 'administration_document_export',
                    'route_params' => ['_format' => 'xlsx'],
                ]);
            },
        ]);

        $builder->addColumn('libelle', PropertyColumnType::class, ['label' => 'titre']);
        $builder->addColumn('typeFichier', PropertyColumnType::class, ['label' => 'type_fichier']);
        $builder->addColumn('typeDocument', CategorieArticleColumnType::class, ['label' => 'categorie']);
        $builder->addColumn('semestres', SemestreColumnType::class, ['label' => 'semestres']);
        $builder->addColumn('updated', DateColumnType::class, [
            'order' => 'DESC',
            'format' => 'd/m/Y',
            'label' => 'updated',
        ]);

        $builder->addColumn('links', WidgetColumnType::class, [
            'build' => function(WidgetBuilder $builder, Document $s) {
                $builder->add('duplicate', RowDuplicateLinkType::class, [
                    'route' => 'administration_document_duplicate',
                    'route_params' => ['id' => $s->getUuidString()],
                    'xhr' => false,
                ]);
                $builder->add('show', RowShowLinkType::class, [
                    'route' => 'administration_document_show',
                    'route_params' => [
                        'id' => $s->getUuidString(),
                    ],
                    'xhr' => false,
                ]);
                $builder->add('edit', RowEditLinkType::class, [
                    'route' => 'administration_document_edit',
                    'route_params' => [
                        'id' => $s->getUuidString(),
                    ],
                    'xhr' => false,
                ]);
                $builder->add('delete', RowDeleteLinkType::class, [
                    'attr' => [
                        'data-href' => 'administration_document_delete',
                        'data-uuid' => $s->getUuidString(),
                        'data-csrf' => $this->csrfToken->getToken('delete' . $s->getId()),
                    ],
                ]);
            },
        ]);

        $builder->useAdapter(EntityAdapter::class, [
            'class' => Document::class,
            'fetch_join_collection' => false,
            'query' => function(QueryBuilder $qb, array $formData) {
                $qb->innerJoin('e.semestres', 'c')//récupération de la jointure dans la table dédiée
                ->innerJoin(Semestre::class, 's', 'WITH', 'c.id = s.id')
                    ->innerJoin(Annee::class, 'a', 'WITH', 's.annee = a.id')
                    ->innerJoin(Diplome::class, 'd', 'WITH', 'a.diplome = d.id')
                    ->where('d.departement = :departement')
                    ->setParameter('departement', $this->departement->getId());

                if (isset($formData['search'])) {
                    $qb->andWhere('LOWER(e.titre) LIKE :search');
                    $qb->orWhere('LOWER(e.texte) LIKE :search');
                    $qb->setParameter('search', '%' . $formData['search'] . '%');
                }

                if (isset($formData['from'])) {
                    $qb->andWhere('e.updated >= :from');
                    $qb->setParameter('from', $formData['from']);
                }

                if (isset($formData['to'])) {
                    $qb->andWhere('e.updated <= :to');
                    $qb->setParameter('to', $formData['to']);
                }
            },
        ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'orderable' => true,
            'departement' => null,
        ]);
    }
}