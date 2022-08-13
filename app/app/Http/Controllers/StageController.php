<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreStageRequest;
use App\Http\Requests\UpdateStageRequest;
use App\Models\Stage;
use App\Models\TypeLicence;

use Illuminate\Http\Request;

class StageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->has('filter') )
        {
            $filter = $request->input('filter');
            $stages = Stage::where('stage_libcourt', 'LIKE', '%'.$filter.'%')->orderBy('stage_libcourt')->paginate(10);
        } else {
            $filter="";
            $stages = Stage::orderBy('stage_libcourt')->paginate(10);
        }
        
        return view('stages.index', ['stages' => $stages,
                                    'filter'  => $filter ] );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('stages.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreStageRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreStageRequest $request)
    {
        $stage=new Stage;
        $stage->stage_libcourt = $request->stage['stage_libcourt'];
        $stage->stage_liblong = $request->stage['stage_liblong'];
        $stage->typelicence_id=4;
        $stage->save();
        return redirect()->route('stages.edit', $stage);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Stage  $stage
     * @return \Illuminate\Http\Response
     */
    public function show(Stage $stage)
    {
        $stages = Stage::orderBy('stage_libcourt')->get();
        $typelicences = TypeLicence::orderBy('typlicense_libcourt')->get();
        return view('stages.show', ['stage'       => $stage, 
                                    'stages'     => $stages,
                                    'typelicences' => $typelicences] );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Stage  $stage
     * @return \Illuminate\Http\Response
     */
    public function edit(Stage $stage)
    {
        $stages = Stage::orderBy('stage_libcourt')->get();
        $typelicences = TypeLicence::orderBy('typlicense_libcourt')->get();
        return view('stages.edit', ['stage'       => $stage, 
                                    'stages'     => $stages,
                                    'typelicences' => $typelicences] );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateStageRequest  $request
     * @param  \App\Models\Stage  $stage
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateStageRequest $request, Stage $stage)
    {
        $stage->stage_libcourt=$request->stage['stage_libcourt'];
        if ($request->stage['stage_liblong'] == null)
            $stage->stage_liblong="";
        else
            $stage->stage_liblong=$request->stage['stage_liblong'];
        $stage->typelicence_id = $request->stage['typelicence_id'];
        if (array_key_exists('transverse', $request->stage))
            $stage->transverse = true;
        else
            $stage->transverse = false;
        $stage->save();
        
        return redirect()->route('stages.edit', $stage);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Stage  $stage
     * @return \Illuminate\Http\Response
     */
    public function destroy(Stage $stage)
    {
        $stage->delete();
        return redirect()->route('stages.index');
    }
}
