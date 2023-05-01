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
    public function test_gantt()
    {
        return view('test.test_gantt');
        
    }

    public function test()
    {
        return view('test.test');
        
    }
}
