<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreStageRequest;
use App\Http\Requests\UpdateStageRequest;
use App\Models\Stage;
use App\Models\TypeLicence;
use App\Models\User;

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
    public function show(Request $request, Stage $stage)
    {
        
        if ($request->has("stage"))
        {
            return redirect()->route('stages.show', intval($request["stage"]));
        }
        $marin = null;
        if ($request->has("marin"))
        {
            $marin = User::find(intval($request["marin"]));
        }
        
        $stages = Stage::orderBy('stage_libcourt')->get();
        $typelicences = TypeLicence::orderBy('typlicense_libcourt')->get();
        $users = User::local()->orderBy('name')->get();
        
        $usersdustage = $stage->users()->get();
        
        return view('stages.show', ['stage'        => $stage, 
                                    'stages'       => $stages,
                                    'typelicences' => $typelicences,
                                    'users'        => $users,
                                    'marin'        => $marin,
                                    'usersdustage' => $usersdustage] );
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
    
    public function attribuerstage(Request $request, Stage $stage)
    {
        if ($request->has('user_id'))
        {
            $user = User::find(intval($request['user_id']));
            $user->stages()->attach($stage);
        }
        return redirect()->route('stages.choixmarins', ['stage'=>$stage]);
    }
    
    public function choixmarins(Stage $stage)
    {
        $users = User::local()->orderBy('name')->get();
        
        $usersdustage = $stage->users()->get();
        
        return view('stages.choisirmarins', ['stage'=>$stage ,
                                             'users' => $users,
                                             'usersdustage' => $usersdustage]);
    }
    
    public function validermarins(Request $request, Stage $stage)
    {
        if ($request->has('user')){
            $userlist = $request['user'];
            foreach (array_keys($userlist) as $userid)
            {
                $user = User::find($userid);
                $workitem = $user->stages()->find($stage)->pivot;
                $workitem->date_validation = $request["date_validation"];
                $workitem->commentaire = $request["commentaire"];
                $workitem->save();
            }
        }
        return redirect()->route('stages.choixmarins', ['stage'=>$stage]);
    }
    
     public function annulermarins(Request $request, Stage $stage)
    {
        if ($request->has('usercancel')){
            $userlist = $request['usercancel'];
            foreach (array_keys($userlist) as $userid)
            {
                $user = User::find($userid);
                $workitem = $user->stages()->find($stage)->pivot;
                $workitem->date_validation = null;
                $workitem->commentaire = null;
                $workitem->save();
            }
        }
        return redirect()->route('stages.choixmarins', ['stage'=>$stage]);
    }

    public function consulter(Request $request)
    {
        $stage = null;
        $marin = null;
        
        if ($request->has("stage"))
        {
            $stage = Stage::find(intval($request["stage"]));
        }
        if ($request->has("marin"))
        {
            $marin = User::find(intval($request["marin"]));
        }
        
        if ($stage and $marin)
            $marin = null;
        
        $stages = Stage::orderBy('stage_libcourt')->get();
        $typelicences = TypeLicence::orderBy('typlicense_libcourt')->get();
        $users = User::local()->orderBy('name')->get();

        $usersdustage =null;
        if ($stage != null)
            $usersdustage = $stage->users()->get();
        
        return view('stages.show', ['stage'        => $stage, 
                                    'marin'        => $marin,
                                    'stages'       => $stages,
                                    'typelicences' => $typelicences,
                                    'users'        => $users,
                                    'usersdustage' => $usersdustage]);
    }
}
