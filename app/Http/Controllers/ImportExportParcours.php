<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Fonction;
use App\Models\Compagnonage;
use App\Models\Tache;
use App\Models\Objectif;
use App\Models\SousObjectif;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Table;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class ImportExportParcours extends Controller
{
    public function exportCompagnonageToExcelSheet($comp, $sheet)
    {
        $sheet->setCellValue('A1', $comp->comp_liblong);
        $sheet->setCellValue('A2', $comp->comp_libcourt);
        
        $firstColumn = 2;
        
        $row = 4;
        $column = $firstColumn;
        
        $sheet->setCellValue([$column++, $row ] , 'Tache ID');
        $sheet->getColumnDimensionByColumn($column-1)->setVisible(false);
        $sheet->setCellValue([$column++, $row ] , 'Tache');
        $sheet->setCellValue([$column++, $row ] , 'Objectif ID');
        $sheet->getColumnDimensionByColumn($column-1)->setVisible(false);
        $sheet->setCellValue([$column++, $row ] , 'Objectif');
        $sheet->setCellValue([$column++, $row ] , 'SousObjectif ID');
        $sheet->getColumnDimensionByColumn($column-1)->setVisible(false);
        $sheet->setCellValue([$column++, $row ] , 'SousObjectif');
        $sheet->setCellValue([$column++, $row ] , 'SousObjectif coeff');
        $sheet->setCellValue([$column++, $row ] , 'SousObjectif duree');
        $sheet->setCellValue([$column++, $row ] , 'SousObjectif lieu');
        
        $sheet->getStyle([$firstColumn, $row, $column, $row])->getFont()->setBold(true);
        
        $row ++;
        $column = $firstColumn;
        
        foreach ($comp->taches as $tache)
        {
            $column = $firstColumn;
            $sheet->setCellValue([$column++, $row ] , $tache->id);
            $sheet->getColumnDimensionByColumn($column - 1)->setWidth(10);
            $sheet->setCellValue([$column++, $row ] , $tache->tache_libcourt);
            $sheet->getColumnDimensionByColumn($column - 1)->setAutoSize(true);
            $objcolumn = $column;
            foreach($tache->objectifs as $objectif)
            {
                $column = $objcolumn;
                $sheet->setCellValue([$column++, $row ] , $objectif->id);
                $sheet->getColumnDimensionByColumn($column - 1)->setWidth(10);
                $sheet->setCellValue([$column++, $row ] , $objectif->objectif_libcourt);
                $sheet->getColumnDimensionByColumn($column - 1)->setAutoSize(true);
                $sobjcolumn = $column;
                foreach ($objectif->sous_objectifs as $sousobj)
                {
                    $column = $sobjcolumn ;
                    $sheet->setCellValue([$column++, $row ] , $sousobj->id);
                    $sheet->getColumnDimensionByColumn($column - 1)->setWidth(10);
                    $sheet->setCellValue([$column++, $row ] , $sousobj->ssobj_lib);
                    $sheet->getColumnDimensionByColumn($column - 1)->setAutoSize(true);
                    $sheet->setCellValue([$column++, $row ] , $sousobj->ssobj_coeff);
                    $sheet->getColumnDimensionByColumn($column - 1)->setAutoSize(true);
                    $sheet->setCellValue([$column++, $row ] , $sousobj->ssobj_duree);
                    $sheet->getColumnDimensionByColumn($column - 1)->setAutoSize(true);
                    $sheet->setCellValue([$column++, $row ] , $sousobj->lieu()->first()?->lieu_libcourt);
                    $sheet->getColumnDimensionByColumn($column - 1)->setAutoSize(true);
                    $row ++;
                }
            }
        }
        // $table = new Table([ $firstColumn , 4, $column, $row ], "Table_" . $comp->id);
        // $sheet->addTable($table);
    }
    
    public function ExportParcoursVersExcel()
    {
        $spreadsheet = new Spreadsheet();
        $sheet= null;
        
        
        foreach (Compagnonage::with('taches.objectifs.sous_objectifs')->get() as $comp)
        {
            if (! $sheet)
                $sheet = $spreadsheet->getActivesheet();
            else
                $sheet= $spreadsheet->createSheet();
            $sheet->setTitle(substr($comp->comp_libcourt, 0, 31));
            $this->exportCompagnonageToExcelSheet($comp, $sheet);
        }
        
        $writer = new Xlsx($spreadsheet);


        header('Content-Type: application/vnc.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="parcours.xlsx"');
        $writer->save('php://output');
        exit();
        
        
        return "coucou";
    }
}
