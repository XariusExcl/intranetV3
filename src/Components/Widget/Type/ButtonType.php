<?php
/*
 * Copyright (c) 2021. | David Annebicque | IUT de Troyes  - All Rights Reserved
 * @file /Users/davidannebicque/htdocs/intranetV3/src/Components/Widget/Type/ButtonType.php
 * @author davidannebicque
 * @project intranetV3
 * @lastUpdate 29/08/2021 14:37
 */

namespace App\Components\Widget\Type;

use App\Components\Widget\DTO\WidgetView;
use App\Components\Widget\WidgetBuilder;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Routing\RouterInterface;

class ButtonType extends WidgetType
{
    protected RouterInterface $router;

    /**
     * LinkType constructor.
     */
    public function __construct(RouterInterface $router)
    {
        $this->router = $router;
    }

    public function buildView(WidgetView $view, array $options)
    {
        parent::buildView($view, $options);
        $view->element = 'button';
        $view->vars['attr']['type'] = 'button';

        $view->vars['attr']['data-xhr'] = $options['url'];

        if (!empty($options['confirm'])) {
            $view->vars['attr']['data-confirm'] = $options['confirm'];
        }

        if ($options['spinner']) {
            $view->vars['attr']['data-spinner'] = 'true';
        }

        $view->vars['attr']['class'] .= ' btn';
    }

    public function buildWidget(WidgetBuilder $builder, array $options)
    {
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);

        $resolver
            ->setDefault('text', null); // enable text

        $resolver
            ->define('route')
            ->default(null)
            ->allowedTypes('string', 'null');

        $resolver
            ->define('url')
            ->allowedTypes('string', 'null')
            ->default(function (Options $options) {
                if ($options['route']) {
                    return $this->router->generate($options['route'], $options['route_params']);
                }
                return null;
            });

        $resolver
            ->define('route_params')
            ->default([])
            ->allowedTypes('array');

        $resolver
            ->define('confirm')
            ->default(null)
            ->allowedTypes('string', 'null');

        $resolver
            ->define('spinner')
            ->default(false)
            ->allowedTypes('bool');
    }
}
