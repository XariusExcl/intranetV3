<?php
/*
 * Copyright (c) 2021. | David Annebicque | IUT de Troyes  - All Rights Reserved
 * @file /Users/davidannebicque/htdocs/intranetV3/src/Components/Questionnaire/Section/ConfigurableSection.php
 * @author davidannebicque
 * @project intranetV3
 * @lastUpdate 03/11/2021 12:20
 */

namespace App\Components\Questionnaire\Section;

use App\Components\Questionnaire\QuestionnaireRegistry;
use App\Components\Questionnaire\Questions;
use App\Components\Questionnaire\TypeQuestion\AbstractQuestion;

class ConfigurableSection
{
    public const NB_QUESTIONS_PAR_SECTION = 3;
    public ?AbstractSectionAdapter $sectionAdapter = null;
    public ?array $config = [];
    public string $type_calcul = '';
    public array $sections = []; //en mode configurable, on peut avoir la création de sections

    private \App\Components\Questionnaire\DTO\Section $section;
    private Questions $questions;
    private QuestionnaireRegistry $questionnaireRegistry;
    private array $valeursParSection;

    public function __construct(QuestionnaireRegistry $questionnaireRegistry)
    {
        $this->questionnaireRegistry = $questionnaireRegistry;
        $this->questions = new Questions();
    }

    public function addQuestions(AbstractQuestion $abstractQuestion)
    {
        //boucler sur toutes les options, et ajouter successivement les questions... QUid des questions enfants ? Logiquement elles ne sont pas envoyées ici
        if (is_array($this->config) && array_key_exists('valeurs', $this->config) && is_array($this->config['valeurs'])) {
            foreach ($this->config['valeurs'] as $valeur) {
                $abstractQuestion->numero = $valeur; //pour tester
                $this->questions->addQuestion($abstractQuestion);
            }
        } else {
            //ce cas ne devrait pas exister...
            $this->questions->addQuestion($abstractQuestion);
        }
    }

    public function initConfigGlobale(?array $config = [])
    {
        $this->sectionAdapter = $this->questionnaireRegistry->getSectionAdapter($config['sectionAdapter']);
    }

    public function initConfigSection(?array $config = [])
    {
        $this->config = $config;
    }

    //todo: ajouter un libelle sur la section pour faciliter la gestion

    public function setSection(\App\Components\Questionnaire\DTO\Section $section)//peut être passer par un dto car on dépend de la BDD...
    {
        $this->section = $section;
        $this->initConfigGlobale($section->configGlobale);
        $this->initConfigSection($section->configQuestionnaire);
    }

    public function genereSections()
    {
        $this->valeursParSection = [];
        if (is_array($this->config) && array_key_exists('valeurs', $this->config) && is_array($this->config['valeurs'])) {
            $nbSections = ceil(count($this->config['valeurs']) / self::NB_QUESTIONS_PAR_SECTION);
            for ($i = 1; $i <= $nbSections; ++$i) {
                $this->valeursParSection[$i] = array_slice($this->config['valeurs'], ($i - 1) * self::NB_QUESTIONS_PAR_SECTION, self::NB_QUESTIONS_PAR_SECTION);
                $numSection = $this->section->ordre.'-'.$i;
                $this->sections[$numSection] = new Section($this->questionnaireRegistry);
                $newSection = clone $this->section; //clonage pour gérer indépendement les sections ?

                // Définir les éléments liés ) la configuration
                $this->sections[$numSection]->nbParties = $this->getQuestionsParPartie($i);
                $this->sections[$numSection]->params = ['valeurs' =>  $this->valeursParSection[$i]];
                $this->sections[$numSection]->configurable = true;
                $this->sections[$numSection]->abstractSectionAdapter = $this->sectionAdapter;

                $newSection->ordre = $numSection;
                $this->sections[$numSection]->setSection($newSection);
            }

            return $this->sections;
        }

        return [];
    }

    private function getQuestionsParPartie(int $i)
    {
        if ($i * self::NB_QUESTIONS_PAR_SECTION <= count($this->config['valeurs'])) {
            return self::NB_QUESTIONS_PAR_SECTION;
        }

        return count($this->config['valeurs']) % self::NB_QUESTIONS_PAR_SECTION;
    }
}