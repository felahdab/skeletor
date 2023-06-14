<?php

namespace Modules\Transformation\Http\Controllers;

use Illuminate\Http\Request;

use Modules\Transformation\Entities\Fonction;
use Modules\Transformation\Entities\Compagnonage;
use Modules\Transformation\Entities\Tache;
use Modules\Transformation\Entities\Objectif;
use Modules\Transformation\Entities\SousObjectif;
use Modules\Transformation\Entities\Stage;

use Illuminate\Support\Str;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Table;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

use App\Http\Controllers\Controller;

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
        $sheet->setCellValue([$column++, $row ] , 'Tache (lib long)');
        $sheet->setCellValue([$column++, $row ] , 'Objectif ID');
        $sheet->getColumnDimensionByColumn($column-1)->setVisible(false);
        $sheet->setCellValue([$column++, $row ] , 'Objectif');
        $sheet->setCellValue([$column++, $row ] , 'Objectif (lib long)');
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
            $sheet->setCellValue([$column++, $row ] , $tache->tache_liblong);
            $sheet->getColumnDimensionByColumn($column - 1)->setAutoSize(true);
            $objcolumn = $column;
            foreach($tache->objectifs as $objectif)
            {
                $column = $objcolumn;
                $sheet->setCellValue([$column++, $row ] , $objectif->id);
                $sheet->getColumnDimensionByColumn($column - 1)->setWidth(10);
                $sheet->setCellValue([$column++, $row ] , $objectif->objectif_libcourt);
                $sheet->getColumnDimensionByColumn($column - 1)->setAutoSize(true);
                $sheet->setCellValue([$column++, $row ] , $objectif->objectif_liblong);
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

    public function exportFoncStageCompToExcelSheet($sheet)
    {
        $stylebordures=[
            'borders' => [
                'top' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
                'bottom' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
                'right' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
                'left' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
            ]
        ];
        $stylefonction=[
            'fill' => [
                'font' => [
                    'bold' => true,
                ],
                'color' => [
                    'argb' => 'c2c2c2',
                ],
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
            ]
        ];
        $stylelache=[
            'fill' => [
                'color' => [
                    'argb' => '0F8CD6',
                ],
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
            ]
        ];
        $firstColumn = 2;
        $firstRow = 2;
        $row = $firstRow;
        foreach (Fonction::orderBy('fonction_libcourt')->get() as $fonc){
            $column = $firstColumn;
            $sheet->setCellValue([$column, $row ] , $fonc->fonction_liblong.' ('.$fonc->fonction_libcourt.')');
            $sheet->getStyle([$column, $row ])->applyFromArray($stylefonction);
            $column ++;
            $double_lach='';
            if ($fonc->fonction_double == 1) $double_lach.='Double/';
            if ($fonc->fonction_lache == 1) $double_lach.='Lâcher';
            $sheet->setCellValue([$column, $row ] , $double_lach);
            $sheet->getStyle([$column, $row ])->applyFromArray($stylelache);
            $column --;
            $row ++;
            $sheet->setCellValue([$column, $row ] , 'Compagnonnages : ');
            $sheet->getStyle([$column, $row ])->applyFromArray($stylebordures);
        foreach ($fonc->compagnonages()->get() as $comp)
            {
                $column ++;
                $sheet->setCellValue([$column, $row ] , $comp->comp_libcourt);
                $sheet->getColumnDimensionByColumn($column - 1)->setAutoSize(true);  
                $sheet->getStyle([$column, $row ])->applyFromArray($stylebordures);
          
            }
            $row ++;
            $column = $firstColumn;
            $sheet->setCellValue([$column, $row ] , 'Stages : ');
            $sheet->getStyle([$column, $row ])->applyFromArray($stylebordures);
        foreach ($fonc->stages()->get() as $stage)
            {
                $column ++;
                $sheet->setCellValue([$column, $row ] , $stage->stage_libcourt);
                $sheet->getColumnDimensionByColumn($column - 1)->setAutoSize(true);            
                $sheet->getStyle([$column, $row ])->applyFromArray($stylebordures);
            }
            $row = $row + 2;
        }

    }

    public function ExportParcoursVersExcel()
    {
        $spreadsheet = new Spreadsheet();
        $sheet= null;
        
        if (! $sheet)
        $sheet = $spreadsheet->getActivesheet();
        else
            $sheet= $spreadsheet->createSheet();
        $sheet->setTitle('Liste Fonctions');
        $this->exportFoncStageCompToExcelSheet($sheet);
        

        foreach (Compagnonage::with('taches.objectifs.sous_objectifs')->get() as $comp)
        {
            if (! $sheet)
                $sheet = $spreadsheet->getActivesheet();
            else
                $sheet= $spreadsheet->createSheet();
            $sheet->setTitle(Str::ascii(substr($comp->comp_libcourt, 0, 31)));
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
