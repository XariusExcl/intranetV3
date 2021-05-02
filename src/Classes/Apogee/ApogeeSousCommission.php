<?php
/*
 * Copyright (c) 2021. | David Annebicque | IUT de Troyes  - All Rights Reserved
 * @file /Users/davidannebicque/htdocs/intranetV3/src/Classes/Apogee/ApogeeSousCommission.php
 * @author davidannebicque
 * @project intranetV3
 * @lastUpdate 02/04/2021 12:09
 */

namespace App\Classes\Apogee;

use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\Exception;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Protection;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ApogeeSousCommission extends Apogee
{
    /**
     * @throws Exception
     */
    public function transformeApogeeTexte($fichier, string $nomfichier): ?StreamedResponse
    {
        $objPEENotes = new Spreadsheet();
        $objPEENotes->setActiveSheetIndex(0);
        $notesSheet = $objPEENotes->getActiveSheet();

        $objPHPExcel = IOFactory::load($fichier);
        $objPHPExcel->setActiveSheetIndex(0);
        $maquetteSheet = $objPHPExcel->getActiveSheet();

        $G_tab_apoL = [];
        $G_tab_apoC = [];

        $G_tab_apoL_Coord = [];
        $G_tab_apoC_Coord = [];

        $i = 0;
        foreach ($objPHPExcel->getNamedRanges() as $name => $namedRange) {
            if (0 === strpos($name, 'APOL_')) {
                $G_tab_apoL[$i] = $namedRange->getName();
                $G_tab_apoL_Coord[$i] = $namedRange->getRange();
                ++$i;
            }
        }

        $i = 0;
        foreach ($objPHPExcel->getNamedRanges() as $name => $namedRange) {
            if (0 === strpos($name, 'APOC_')) {
                $G_tab_apoC[$i] = $namedRange->getName();
                $G_tab_apoC_Coord[$i] = $namedRange->getRange();
                ++$i;
            }
        }

        $v_cell_apo_col_val_fin = 0;

        // deprotection feuille
        $maquetteSheet->getStyle('A1:GV200')->getProtection()->setLocked(Protection::PROTECTION_UNPROTECTED);
        $maquetteSheet->getProtection()->setSheet(true);
        $i = 17;
        // nombre de lignes
        while ('' != trim($maquetteSheet->getCellByColumnAndRow(1, $i)->getValue())) {
            ++$i;
        }
        $v_nb_lig = $i - 1;
        // repere 1
        $notesSheet->setCellValue('A1', 'XX-APO_TITRES-XX');
        // 1ere colonne
        $i = 1;
        // 2ème ligne
        $j = 2;
        foreach ($G_tab_apoC_Coord as $key => $name) {
            $val = $maquetteSheet->getCell($name)->getValue();
            $notesSheet->setCellValueByColumnAndRow($i, $j, $G_tab_apoC[$key]);
            $notesSheet->setCellValueByColumnAndRow(($i + 1), $j, $val);
            ++$j;
        }

        // repere 2
        ++$j;
        $notesSheet->setCellValueByColumnAndRow($i, $j, 'XX-APO_COLONNES-XX');
        ++$j;

        // tableau des libelles
        foreach ($G_tab_apoL_Coord as $key => $name) {
            // recupere les coordonnees de la cellule dont le nom est $name
            $deb = $maquetteSheet->getCell($name)->getCoordinate();

            // fin = calcul du décalage vertical de 11 lignes à partir de la cellule ci-dessus
            $fin = $this->getNewCoordinates($deb, 0, 11);
            $v_cell_occ = 0;
            $v_cpt_cell_vide = $maquetteSheet->getCell($deb)->getValue();
            if (!empty($v_cpt_cell_vide)) {
                if ('APO_COL_VAL_FIN' === $v_cpt_cell_vide ||
                    'APO_COL_VAL_FIN' === $maquetteSheet->getCell($this->getNewCoordinates($deb, 0, 1))->getValue()
                ) {
                    $v_cell_apo_col_val_fin = $name;
                    $v_cell_occ = 2;
                } else {
                    $v_cell_occ = 1;
                }
            }

            // on est à la fin des codes on tague le fichier texte
            if ($v_cell_occ == 2) {
                $notesSheet->setCellValueByColumnAndRow(1, $j, 'APO_COL_VAL_FIN');
                ++$j;
                $v_cell_occ = 1;
            }

            // recopie de la ligne de codes
            if ($v_cell_occ == 1) {
                // copie les cellules de la selection deb:fin (colonne)
                $cellValues = $maquetteSheet->rangeToArray($deb . ':' . $fin);

                // colle les cellules transposées (en ligne)
                foreach ($cellValues as $cellValue) {
                    $notesSheet->setCellValueByColumnAndRow($i, $j, $cellValue[0]);
                    ++$i;
                }

                // conversion_adm_temoin
                $cellule = $notesSheet->getCellByColumnAndRow(10, $j);
                if (empty($cellule->getValue()) && $v_cell_apo_col_val_fin == 0) {
                    $cellule->setValue(1);
                }
                if ('x' === $cellule->getValue()) {
                    $cellule->setValue(0);
                }
                //-- fin conversion_adm_temoin --

                if ('apol_a04_naissance' === mb_strtolower($G_tab_apoL[$key])) {
                    $notesSheet->setCellValueByColumnAndRow(1, $j + 1, 'APO_COL_VAL_DEB');
                    ++$j;
                }
            }

            if ('APO_COL_VAL_FIN' === $v_cpt_cell_vide ||
                'APO_COL_VAL_FIN' === $maquetteSheet->getCell($this->getNewCoordinates($deb, 0, 1))->getValue()
            ) {
                break;
            }

            // colonne 1
            $i = 1;

            // ligne suivante
            ++$j;
        }

        $celluleFin = $maquetteSheet->getCell($v_cell_apo_col_val_fin)->getCoordinate();

        ++$j;
        ++$j;
        $notesSheet->setCellValueByColumnAndRow(1, $j, 'XX-APO_VALEURS-XX');
        ++$j;
        // 1ere colonne
        $i = 1;
        // sauvegarde $j (numero de ligne)
        $k = $j;

        // tableau des codes
        foreach ($G_tab_apoL_Coord as $key => $name) {
            // recupere les coordonnees de la cellule qui porte le label $name
            $titre = $maquetteSheet->getCell($name)->getCoordinate();

            // cellule debut pour la copie
            $deb = $this->getNewCoordinates($titre, 0, 12);
            $numLigne = $maquetteSheet->getCell($name)->getRow();

            // cellule de fin
            $fin = $this->getNewCoordinates($titre, 0, $v_nb_lig - $numLigne);
            // si on est pas a la derniere colonne
            if ($titre != $celluleFin) {

                // copie les cellules de la selection deb:fin (colonne)
                $cellValues = $maquetteSheet->rangeToArray($deb . ':' . $fin);

                // recupere le titre
                $val_titre = $maquetteSheet->getCell($titre)->getValue();
                ++$j;

                // colle les donnees dans la bonne colonne
                foreach ($cellValues as $cellValue) {
                    if ('-0.01' === $cellValue[0]) {
                        $notesSheet->setCellValueByColumnAndRow($i, $j, 0);
                    } else {
                        $notesSheet->setCellValueByColumnAndRow($i, $j, $cellValue[0]);
                    }

                    if ('apol_a01_code' !== mb_strtolower($G_tab_apoL[$key]) && 'apol_a02_nom' !== mb_strtolower($G_tab_apoL[$key]) && 'apol_a03_prenom' !== mb_strtolower($G_tab_apoL[$key]) && 'apol_04_naissance' !== mb_strtolower($G_tab_apoL[$key])) {
                        $cell = Coordinate::stringFromColumnIndex($i) . $j;
                        $notesSheet->getStyle($cell)->getNumberFormat()->setFormatCode('#,##0.00');
                    }
                    ++$j;
                }

                // recupere le bon numero de ligne pour refaire un collage dans la colonne suivante
                $j = $k;

                // colle le titre de la colonne
                $notesSheet->setCellValueByColumnAndRow($i, $j, $val_titre);
            } else {// stoppe tout si derniere colonne
                break;
            }

            // colonne suivante
            ++$i;
        }

        // enregistrement du fichier
        $objWriter = IOFactory::createWriter($objPEENotes, 'Csv');
        $objWriter->setEnclosure('');
        $objWriter->setDelimiter("\t");
        $objWriter->setLineEnding("\r\n"); // cr lf (Windows)
        ob_start();
        $excelOutput = ob_get_clean();

        // conversion en iso-8859-1, car PHPExcel genere de l'utf-8
        $f = mb_convert_encoding($excelOutput, 'iso-8859-1');
        $f = trim($f) . "\r\n";

        return new StreamedResponse(
            function() use ($objWriter) {
                $objWriter->save('php://output');
            },
            200,
            [
                'Content-Type' => 'text/plain',
                'Content-Disposition' => 'attachment;filename="' . $nomfichier . '.txt"',
                'Cache-Control' => 'max-age=0',
            ]
        );
    }

    /**
     * Calcule les nouvelles coordonnées d'une cellule à partir des offsets x et y.
     *
     * @param $cellCoordonate
     */
    public function getNewCoordinates($cellCoordonate, int $offsetX = 0, int $offsetY = 0): string
    {
        if (2 === mb_strlen($cellCoordonate)) {
            $colonne = mb_substr($cellCoordonate, 0, 1);
            $ligne = (int)mb_substr($cellCoordonate, 1, 5);
        } else {
            $colonne = mb_substr($cellCoordonate, 0, 2);
            $ligne = (int)mb_substr($cellCoordonate, 2, 5);
        }
        if (0 !== $offsetX) { // decalage colonne
            $colonne += $offsetX;
        }
        if (0 !== $offsetY) { // decalage ligne
            $ligne += $offsetY;
        }

        return $colonne . $ligne;
    }
}