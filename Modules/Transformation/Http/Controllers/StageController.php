<?php

namespace Modules\Transformation\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\Transformation\Service\GererTransformationService;
use Modules\Transformation\Services\RecalculerTransformationService;

use Illuminate\Support\Carbon;

use App\Http\Requests\StoreStageRequest;
use App\Http\Requests\UpdateStageRequest;
use Modules\Transformation\Entities\Stage;
use Modules\Transformation\Entities\TypeLicence;
use Modules\Transformation\Entities\User;

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
        return view('transformation::stages.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $typelicences = TypeLicence::orderBy('typlicense_libcourt')->get();
        return view('transformation::stages.create', ['typelicences' => $typelicences,]);
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
        $stage->transverse = array_key_exists('transverse', $request->stage) ;
        $stage->typelicence_id=$request->stage['typelicence_id'];
        $stage->stage_lieu = $request->stage['stage_lieu'];
        if(is_numeric($request->stage['stage_duree'])){
            $stage->stage_duree = $request->stage['stage_duree'];
        }
        if(is_numeric($request->stage['duree_validite'])){
            $stage->duree_validite = $request->stage['duree_validite'];
        }
        $stage->stage_capamax = $request->stage['stage_capamax'];
        $stage->stage_date_fin_licence = $request->stage['stage_date_fin_licence'];
        $stage->stage_lienurl = $request->stage['stage_lienurl'];
        $stage->stage_commentaire = $request->stage['stage_commentaire'];
        $stage->save();
        return redirect()->route('transformation::stages.edit', $stage);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Stage  $stage
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Stage $stage)
    {    
        $usersdustage = $stage->users()->orderBy('name')->get();
        return view('transformation::stages.show', ['stage'        => $stage, 
                                    'usersdustage' => $usersdustage]);
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
        return view('transformation::stages.edit', ['stage'       => $stage, 
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
        $olddureevalidite=$stage->duree_validite;
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
        $stage->stage_lieu = $request->stage['stage_lieu'];
        if($request->stage['stage_duree'] == null || is_numeric($request->stage['stage_duree'])){
            $stage->stage_duree = $request->stage['stage_duree'];
        }
        if($request->stage['duree_validite'] == null || (is_numeric($request->stage['duree_validite']) && $request->stage['duree_validite'] > 0 )){
            $stage->duree_validite = $request->stage['duree_validite'];
        }
        $stage->stage_capamax = $request->stage['stage_capamax'];
        $stage->stage_date_fin_licence = $request->stage['stage_date_fin_licence'];
        $stage->stage_commentaire = $request->stage['stage_commentaire'];
        $stage->stage_lienurl = $request->stage['stage_lienurl'];
        if($stage->save() && $stage->duree_validite != $olddureevalidite){
            if($stage->duree_validite != $olddureevalidite){
                $stage->miseajourdatevalidite();
            }
        }
        return redirect()->route('transformation::stages.edit', $stage);
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
        RecalculerTransformationService::handle();
        return redirect()->route('transformation::stages.index');
    }
    
    public function attribuerstage(Request $request, Stage $stage)
    {
        if ($request->has('user_id'))
        {
            $transformationService = new GererTransformationService;
            $user = User::find(intval($request['user_id']));
            $transformationService->attachStage($user, $stage);
        }
        return redirect()->route('transformation::stages.choixmarins', ['stage'=>$stage]);
    }
    
    public function validermarins(Request $request, Stage $stage)
    {
        if ($request->has('user')){
            $userlist = $request['user'];
            $nbmois= $stage->duree_validite;
            $date_validite= NULL;
            if($nbmois){
                $date_validite= new Carbon($request["date_validation"]);
                $date_validite = $date_validite->addMonth($nbmois);
            }
            foreach (array_keys($userlist) as $userid)
            {
                $user = User::find($userid);
                $workitem = $user->stages()->find($stage)->pivot;
                $workitem->date_validation = $request["date_validation"];
                $workitem->date_validite = $date_validite;
                $workitem->commentaire .= ' ' . $request["commentaire"];
                $workitem->save();
            }
            RecalculerTransformationService::handle();
        }
        return redirect()->route('transformation::stages.show', ['stage'=>$stage]);
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
                $workitem->date_validite = null;
                $workitem->save();
            }
            RecalculerTransformationService::handle();
        }
        return redirect()->route('transformation::stages.show', ['stage'=>$stage]);
    }  

    public function stages_du_marin(User $user) 
    {
        return view('transformation::transformation.stages', [
            'marin' => $user
        ]);
    }
}
