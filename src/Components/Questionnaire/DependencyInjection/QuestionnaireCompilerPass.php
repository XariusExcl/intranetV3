<?php
/*
 * Copyright (c) 2021. | David Annebicque | IUT de Troyes  - All Rights Reserved
 * @file /Users/davidannebicque/htdocs/intranetV3/src/Components/Questionnaire/DependencyInjection/QuestionnaireCompilerPass.php
 * @author davidannebicque
 * @project intranetV3
 * @lastUpdate 02/08/2021 17:54
 */

namespace App\Components\Questionnaire\DependencyInjection;

use App\Components\Questionnaire\QuestionnaireRegistry;
use App\Components\Table\TableRegistry;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;

class QuestionnaireCompilerPass implements CompilerPassInterface
{
    /**
     * You can modify the container here before it is dumped to PHP code.
     */
    public function process(ContainerBuilder $container)
    {
        $registry = $container->getDefinition(QuestionnaireRegistry::class);
        $this->addToRegistry($container, $registry, QuestionnaireRegistry::TAG_TYPE_QUESTION, 'registerTypeQuestion');
        $this->addToRegistry($container, $registry, QuestionnaireRegistry::TAG_TYPE_SECTION, 'registerTypeSection');

    }

    private function addToRegistry(ContainerBuilder $container, Definition $registry, string $tag, string $method)
    {
        $taggedServices = $container->findTaggedServiceIds($tag);

        foreach ($taggedServices as $id => $tags) {
            $registry->addMethodCall($method, [$id, new Reference($id)]);
        }
    }
}