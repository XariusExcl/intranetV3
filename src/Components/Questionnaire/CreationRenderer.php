<?php
/*
 * Copyright (c) 2021. | David Annebicque | IUT de Troyes  - All Rights Reserved
 * @file /Users/davidannebicque/htdocs/intranetV3/src/Components/Questionnaire/QuestionnaireRenderer.php
 * @author davidannebicque
 * @project intranetV3
 * @lastUpdate 23/10/2021 10:37
 */

namespace App\Components\Questionnaire;

use App\Entity\QuestQuestion;
use App\Entity\QuestSection;
use Twig\Environment;

class CreationRenderer
{
    public function __construct(
        protected QuestionnaireRegistry $questionnaireRegistry,
        protected Environment $twig
    ) {
    }

    /**
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     * @throws \Twig\Error\LoaderError
     * @throws \JsonException
     */
    public function sectionCreationRender(QuestSection $section): string
    {
        return $this->twig->render('components/questionnaire/creation/section.html.twig', $this->viewSection($section));
    }

    /**
     * @throws \Twig\Error\SyntaxError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\LoaderError
     * @throws \JsonException
     */
    public function questionCreationRender(QuestQuestion $question): string
    {
        return $this->twig->render('components/questionnaire/creation/question.html.twig',
            $this->viewQuestion($question));
    }

    /**
     * @throws \JsonException
     */
    private function viewSection(QuestSection $section): array
    {
        $vars = [];
        $vars['options']['mode'] = 'affiche';
        $vars['config'] = $section->getConfig();
        $vars['questions'] = $section->getQuestQuestions();
        $vars['section'] = $section;
        $vars['lastSection'] = $section->getQuestionnaire()->getQuestSections()->count(); //ou last?

        return $vars;
    }

    /**
     * @throws \JsonException
     */
    private function viewQuestion(QuestQuestion $question): array
    {
        $typeQuestion = $this->questionnaireRegistry->getTypeQuestion($question->getType());
        $vars = [];
        $vars['options']['mode'] = 'affiche';
        $vars['badge'] = $typeQuestion::BADGE;
        $vars['type_question'] = $typeQuestion::LABEL;
        $vars['config'] = $question->getConfig();
        $vars['question'] = $question;
        $vars['section'] = $question->getSection();
        $vars['lastQuestion'] = $question->getSection()?->getQuestQuestions()->count();

        return $vars;
    }
}
