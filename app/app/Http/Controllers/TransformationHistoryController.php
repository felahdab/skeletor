<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTransformationHistoryRequest;
use App\Http\Requests\UpdateTransformationHistoryRequest;
use App\Models\TransformationHistory;

class TransformationHistoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('transformationhistory.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreTransformationHistoryRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTransformationHistoryRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TransformationHistory  $transformationHistory
     * @return \Illuminate\Http\Response
     */
    public function show(TransformationHistory $transformationHistory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TransformationHistory  $transformationHistory
     * @return \Illuminate\Http\Response
     */
    public function edit(TransformationHistory $transformationHistory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateTransformationHistoryRequest  $request
     * @param  \App\Models\TransformationHistory  $transformationHistory
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTransformationHistoryRequest $request, TransformationHistory $transformationHistory)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TransformationHistory  $transformationHistory
     * @return \Illuminate\Http\Response
     */
    public function destroy(TransformationHistory $transformationHistory)
    {
        //
    }
}
