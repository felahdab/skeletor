<div x-cloak x-show="opendivvalid" id='divvalid' class='popupvalidcontrat'>
    <div class='titrenavbarvert'>
        <h5>Validation</h5>
    </div>
    <input type='hidden' id='formtosubmit' name='formtosubmit' value=''>
    <div class='form-group row pl-3 mt-2' >
        <label for='datvalid' class='col-sm-5 col-form-label '>Date validation</label>
        <div class='col-sm-5'>
            <input type='date' class='form-control'name='date_validation' id='date_validation' required x-model="date_validation">
        </div>
    </div>
    <div class='form-group row  pl-3' x-show='readwrite'>
        <label for='valideur' class='col-sm-5 col-form-label '>Valideur</label>
        <div class='col-sm-5'>
            <input type='text' class='form-control' name='valideur' id='valideur' placeholder='Valideur' x-model="valideur">
        </div>
    </div>
    <div class='form-group row  pl-3' >
        <label for='comment' class='col-sm-5 col-form-label '>Commentaire</label>
        <div class='col-sm-5'>
            <textarea cols='40' rows='4' name='commentaire' id='commentaire' placeholder='Commentaire' x-model="commentaire"></textarea>
        </div>
    </div>
@if ($mode=='unique')
    <div class='text-center'>
        <button class='btn btn-primary w-25 mt-4 mr-2 mb-2' 
        id='btnvalidobj' 
        name='btnvalidobj'
        x-on:click="opendivvalid = false;
                    $dispatch('uservalidated');">Valider</button>
        <button class='btn btn-primary w-25 mt-4 mb-2' x-on:click='opendivvalid=false;'>Annuler</button>
    </div>
@elseif($mode=='multiple')
    <div class='form-group row'>
        <label for='marinsfonc' class='col-sm-5 col-form-label '>S&eacute;lectionnez les marins à valider</label>
        <div class='col w-100'>
            <select x-model="selected_marins" multiple>
            @foreach($usersfonction as $user)
                <option value ='{{$user->id}}'>{{$user->display_name}}</option>
            @endforeach
            </select>
        </div>
    </div>
    <div class='text-center'>
        <button class='btn btn-primary w-25 mt-4 mr-2 mb-2' 
                type='submit' 
                form='formlivretfonc' 
                id='btnvalidobjusers' 
                name='btnvalidobjusers'
                x-on:click.prevent="$dispatch('uservalidated');
                                    opendivvalid=false;">Valider</button>
        <button class='btn btn-primary w-25 mt-4 mb-2' 
                type='reset' 
                form='formlivretfonc' 
                x-on:click.prevent='opendivvalid=false;'>Annuler</button>
    </div>
@elseif($mode=='parcomp')
    <div class='text-center'>
        <button class='btn btn-primary w-25 mt-4 mr-2 mb-2' 
        id='btnvalidobjcomp' 
        name='btnvalidobjcomp'
        x-on:click="opendivvalid = false;
                    $dispatch('uservalidated');">Valider</button>
        <button class='btn btn-primary w-25 mt-4 mb-2' x-on:click='opendivvalid=false;'>Annuler</button>
    </div>
@endif
</div> <!-- fin de la divvalid -->
