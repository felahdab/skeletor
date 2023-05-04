<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Fonction;
use App\Models\User;
use App\Mail\EssaiMail;
use Illuminate\Support\Facades\Mail;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// use App\Events\UserTransformationUpdated;

use App\Jobs\CalculateUserTransformationRatios;

class TestController extends Controller
{
    public function test()
    {
        // Mail::to("florian.el-ahdab@intradef.gouv.fr")->queue(new EssaiMail());
        // return redirect()->route("home.index")->withSuccess("Mail sent");
        
        // $spreadsheet = new Spreadsheet();
        // $sheet= $spreadsheet->getActivesheet();
        // $sheet->setCellValue('A1', 'Helo world!');
        // $writer = new Xlsx($spreadsheet);
        // header('Content-Type: application/vnc.openxmlformats-officedocument.spreadsheetml.sheet');
        // header('Content-Disposition: attachment; filename="test.xlsx"');
        // $writer->save('php://output');
        // exit();
        return view("test.test");
    }
}
