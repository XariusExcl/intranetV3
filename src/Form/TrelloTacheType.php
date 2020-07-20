<?php
// Copyright (c) 2020. | David Annebicque | IUT de Troyes  - All Rights Reserved
// @file /Users/davidannebicque/htdocs/intranetV3/src/Form/TrelloTacheType.php
// @author davidannebicque
// @project intranetV3
// @lastUpdate 20/07/2020 18:05

namespace App\Form;

use App\Entity\Personnel;
use App\Entity\TrelloTache;
use App\Repository\PersonnelRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class TrelloTacheType
 * @package App\Form
 */
class TrelloTacheType extends AbstractType
{
    private $formation;

    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $this->formation = $options['formation'];

        $builder
            ->add('libelle', TextType::class, ['label' => 'label.libelle'])
            ->add('deadline', DateTimeType::class, ['label' => 'label.deadline'])
            ->add('description', TextareaType::class, ['label' => 'label.description'])
            ->add('personnels', EntityType::class, [
                'class'         => Personnel::class,
                'label'         => 'label.personnel',
                'choice_label'  => 'display',
                'query_builder' => function(PersonnelRepository $personnelRepository) {
                    return $personnelRepository->findByDepartementBuilder($this->formation);
                },
                'attr'          => ['class' => 'form-control selectpicker'],
                'required'      => true,
                'expanded'      => true,
                'multiple'      => true
            ]);
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class'         => TrelloTache::class,
            'departement'          => null,
            'translation_domain' => 'form'
        ]);
    }
}
