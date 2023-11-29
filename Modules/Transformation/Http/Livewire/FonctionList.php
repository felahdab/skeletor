<?php

namespace Modules\Transformation\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Illuminate\Support\Facades\File;


use Modules\Transformation\Entities\Fonction;

class FonctionList extends Component
{
    public $fileUrl  ='';
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    
    public $filter="";
    public $mode="gestion";
    
    public function updatingFilter()
    {
        $this->resetPage();
    }
    
    public function render()
    {
        return view('transformation::livewire.fonction-list', [
            'fonctions' => Fonction::where('fonction_libcourt', 'like', '%'. $this->filter . '%')
                    ->orWhere('fonction_liblong', 'like', '%'. $this->filter . '%')
                    ->OrderBy('fonction_libcourt')
                    ->paginate(10),
        ]);
    }

    public function enregistrerFonctions(){
        ini_set('memory_limit', '512M');
        set_time_limit(300);
        
        $directoryPath = storage_path('app/' . config('transformation.storage_path') );
        if(!File::exists($directoryPath)){
            File::makeDirectory($directoryPath, 0755, true);
        }

        $fileName = 'TransformationFonctions_' . time() . '.xlsx';
        $filePath = $directoryPath . '/' . $fileName;
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'Fonction Libcourt');
        $sheet->setCellValue('B1', 'Fonction Liblong');

        $fonctions = Fonction::get();
        $row = 2;
        foreach ($fonctions as $fonction) {
            $sheet->setCellValue('A' . $row, $fonction->fonction_libcourt);
            $sheet->setCellValue('B' . $row, $fonction->fonction_liblong);
            $row++;
        }
        $writer = new Xlsx($spreadsheet);
        $writer->save($filePath);

        $this->fileUrl = asset(config('transformation.storage_path') . '/' . $fileName);
    }
}