<?php
/*
 * Copyright (c) 2021. | David Annebicque | IUT de Troyes  - All Rights Reserved
 * @file /Users/davidannebicque/htdocs/intranetV3/src/Command/GenereCodeApogeeCommand.php
 * @author davidannebicque
 * @project intranetV3
 * @lastUpdate 03/06/2021 12:06
 */

namespace App\Command;

use App\Classes\Apogee\GenereCodeApogee;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class GenereCodeApogeeCommand extends Command
{
    protected static $defaultName = 'app:genere-code-apogee';
    protected static string $defaultDescription = 'Génére les codes Apogées pour les nouveaux diplôme du B.U.T.';
    protected EntityManagerInterface $entityManager;

    /**
     * GenereCodeApogeeCommand constructor.
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;

        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->setDescription(self::$defaultDescription)
            ->addArgument('departement', InputArgument::REQUIRED, 'Sigle du diplôme')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $arg1 = $input->getArgument('departement');

        if ($arg1) {
            $maquette = new GenereCodeApogee($this->entityManager);

            if (false === $maquette->checkDiplome($arg1)) {
                $io->error('Le diplôme n\'existe pas');
            }

            $value = $maquette->genereCodes();

            if (true === $value) {
                $io->success('Codes générés avec succès');

                return Command::SUCCESS;
            }

            $io->success('Erreur lors de la génération des codes');

            return Command::FAILURE;
        }

        $io->error('Vous devez préciser le sigle du diplôme');

        return Command::FAILURE;
    }
}