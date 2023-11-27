<?php

namespace Modules\Transformation\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

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
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'Fonction Libcourt');
        $sheet->setCellValue('B1', 'Fonction Liblong');
        $fonctions = Fonction::limit(10)->get();
        $row = 2;
        foreach ($fonctions as $fonction) {
            $sheet->setCellValue('A' . $row, $fonction->fonction_libcourt);
            $sheet->setCellValue('B' . $row, $fonction->fonction_liblong);
            $row++;
        }
        $fileName = 'TransformationFonctions_' . time() . '.xlsx';
        $filePath = storage_path('app/public/' . $fileName);
    
        $writer = new Xlsx($spreadsheet);
        $writer->save($filePath);
    
        $this->fileUrl = asset('public/' . $fileName);
    }
}