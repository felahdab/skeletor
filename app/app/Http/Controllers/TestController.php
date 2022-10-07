<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Fonction;
use App\Models\User;
use App\Mail\EssaiMail;
use Illuminate\Support\Facades\Mail;

// use App\Events\UserTransformationUpdated;

use App\Jobs\CalculateUserTransformationRatios;

class TestController extends Controller
{
    public function test()
    {
        Mail::to("florian.el-ahdab@intradef.gouv.fr")->queue(new EssaiMail());
        return redirect()->route("home.index")->withSuccess("Mail sent");
        
    }
}
