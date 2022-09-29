<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Fonction;
use App\Models\User;

// use App\Events\UserTransformationUpdated;

use App\Jobs\CalculateUserTransformationRatios;

class TestController extends Controller
{
    public function test()
    {
        $user = User::find(1);
        CalculateUserTransformationRatios::dispatch($user);
        return view('test.test');
        
    }
}
