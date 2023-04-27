<div class="modal fade" id="bugreport-modal" tabindex=-1>
    {!! Form::open(['method' => 'POST','route' => ['bugreports.store'], 'style'=>'display:inline']) !!}
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Rapport d'anomalie ou suggestion</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input type='hidden' id='url' name='url' value='{{ Request::url() }}'>
                <div class='form-group row  pl-3' >
                        <textarea class="w-100" cols='40' rows='10' name='message' id='message' placeholder='Commentaire'></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                <button type="submit" class="btn btn-primary">Valider</button>
            </div>
        </div>
    </div>
    {!! Form::close() !!}
</div>