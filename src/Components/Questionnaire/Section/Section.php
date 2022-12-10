<?php
/*
 * Copyright (c) 2021. | David Annebicque | IUT de Troyes  - All Rights Reserved
 * @file /Users/davidannebicque/htdocs/intranetV3/src/Components/Questionnaire/Section/Section.php
 * @author davidannebicque
 * @project intranetV3
 * @lastUpdate 04/11/2021 12:03
 */

namespace App\Components\Questionnaire\Section;

use App\Components\Questionnaire\Adapter\QuestionnaireQuestionAdapter;
use App\Components\Questionnaire\DTO\ListeChoix;
use App\Components\Questionnaire\DTO\ReponsesEtudiant;
use App\Components\Questionnaire\DTO\ReponsesEtudiants;
use App\Components\Questionnaire\TypeQuestion\AbstractQuestion;

class Section extends AbstractSection
{
    final public const LABEL = 'question.section';
    public string $type_calcul = '';

    public function getQuestions(): array
    {
        return $this->questions->getQuestions();
    }

    public function getVars(): array
    {
        return array_merge(parent::getVars(), [
            'ordre' => $this->section->ordre,
            'titre' => $this->section->titre,
            'questions' => $this->getQuestions(),
        ]);
    }

    public function initConfigGlobale(?array $config = []): void
    {
    }

    public function initConfigSection(?array $config = []): void
    {
    }

    public function getSection(): Section
    {
        return $this;
    }

    /**
     * @throws \App\Components\Questionnaire\Exceptions\TypeQuestionNotFoundException
     */
    public function prepareQuestions(array $options = [], ?ReponsesEtudiant $reponsesEtudiant = null): void
    {
        foreach ($this->section->questions as $question) {
            $questionnaireQuestionAdapter = new QuestionnaireQuestionAdapter($this->questionnaireRegistry,
                $this->graphRegistry);
            for ($i = 0; $i < $this->nbParties; ++$i) {
                $this->addQuestion(
                    $questionnaireQuestionAdapter->createFromEntity(
                        $this,
                        $question,
                        $i,
                        $options)->setReponseEtudiant($reponsesEtudiant)->getQuestion());
            }
        }
    }

    public function addQuestion(AbstractQuestion $question): void
    {
        // ajouter dans la section concernée...
        $this->questions->addQuestion($question);
    }

    public function calculResultatsQuestions(array $options = [], ListeChoix $listeChoix): void
    {
        foreach ($this->section->questions as $question) {
            $questionnaireQuestionAdapter = new QuestionnaireQuestionAdapter($this->questionnaireRegistry,
                $this->graphRegistry);
            $this->addQuestion(
                $questionnaireQuestionAdapter->createFromEntity(
                    $this,
                    $question,
                    0,
                    $options)->setReponsesEtudiants($listeChoix)->getQuestion());
        }
    }
}
