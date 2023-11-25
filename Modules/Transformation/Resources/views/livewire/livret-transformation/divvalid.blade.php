<div class="modal fade" id="divvalid" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" style="z-index: 99999">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Validation</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input type='hidden' id='formtosubmit' name='formtosubmit' value=''>
                <div class='form-group row mt-2' >
                    <label for='datvalid' class='col-sm-3 col-form-label '>Date validation</label>
                    <div class='col-sm-9'>
                        <input type='date' class='form-control'name='date_validation' id='date_validation' x-model="date_validation">
                    </div>
                </div>
                <div class='form-group row mt-3' x-show='mode != "proposition"'>
                    <label for='valideur' class='col-sm-3 col-form-label '>Valideur</label>
                    <div class='col-sm-9'>
                        <input type='text' class='form-control' name='valideur' id='valideur' placeholder='Valideur' x-model="valideur">
                    </div>
                </div>
                <div class='form-group row mt-3' >
                        <textarea class="form-control" rows='4' name='commentaire' id='commentaire' placeholder='Commentaire' x-model="commentaire"></textarea>
                </div>

    @switch ($mode)
    @case ('modificationmultiple')
                <div class='form-group row mt-2'>
                    <label for='marinsfonc' class='col-sm-3'>S&eacute;lectionnez les marins à valider</label>
                    <div class='col-sm-9'>
                        <select class="form-select" x-model="selected_marins" multiple>
                        @foreach($usersfonction as $user)
                            <option value ='{{$user->id}}'>{{$user->display_name}}</option>
                        @endforeach
                        </select>
                    </div>
                </div>
            </div><!-- modal-body -->
            <div class="modal-footer">
                <button type="button" 
                        class="btn btn-secondary" 
                        data-bs-dismiss="modal"
                        x-on:click="opendivvalid=false;">Annuler</button>
                <button type="button" 
                        class="btn btn-primary"
                        data-bs-dismiss="modal"
                        x-on:click="opendivvalid=false;
                        $dispatch('uservalidated');">Valider</button>
            </div>
        @break
    @case ('modification')
    @case ('modiflivret')
    @case ('validelacherdouble')
    @case ('proposition')
    @case ('parcomp')
            </div><!-- modal-body -->
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                <button type="button" 
                        class="btn btn-primary"
                        data-bs-dismiss="modal"
                        x-on:click="opendivvalid=false; $dispatch('uservalidated');">Valider</button>
            </div>
        @break
        @case ('consultation')
            </div><!-- modal-body -->
        @break
    @endswitch
        </div><!-- modal-content -->
    </div><!-- modal-dialog modal-lg -->
</div><!-- divvalid -->
