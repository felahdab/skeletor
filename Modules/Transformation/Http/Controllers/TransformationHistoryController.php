<?php

namespace Modules\Transformation\Http\Controllers;

use App\Http\Controllers\Controller;

class TransformationHistoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('transformation::transformationhistory.index');
    }

   }
