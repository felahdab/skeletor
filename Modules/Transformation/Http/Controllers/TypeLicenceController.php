<?php

namespace Modules\Transformation\Http\Controllers;

use App\Http\Requests\StoreTypeLicenceRequest;
use App\Http\Requests\UpdateTypeLicenceRequest;
use Modules\Transformation\Entities\TypeLicence;

use App\Http\Controllers\Controller;

class TypeLicenceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * @param  \App\Http\Requests\StoreTypeLicenceRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTypeLicenceRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TypeLicence  $typeLicence
     * @return \Illuminate\Http\Response
     */
    public function show(TypeLicence $typeLicence)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TypeLicence  $typeLicence
     * @return \Illuminate\Http\Response
     */
    public function edit(TypeLicence $typeLicence)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateTypeLicenceRequest  $request
     * @param  \App\Models\TypeLicence  $typeLicence
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTypeLicenceRequest $request, TypeLicence $typeLicence)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TypeLicence  $typeLicence
     * @return \Illuminate\Http\Response
     */
    public function destroy(TypeLicence $typeLicence)
    {
        //
    }
}
