<div id='bugreport' class="border mx-auto w-50" style='display:none;'>
    {!! Form::open(['method' => 'POST','route' => ['bugreports.store'], 'style'=>'display:inline']) !!}
    <div class='titrenavbarvert'>
        <h5>Rapport d'anomalie</h5>
    </div>
    <input type='hidden' id='url' name='url' value='{{ Request::url() }}'>
    <div class='form-group row  pl-3' >
        <label for='comment' class='col-sm-5 col-form-label '>Commentaire</label>
        <div class='col-sm-5'>
            <textarea cols='40' rows='4' name='message' id='message' placeholder='Commentaire'></textarea>
        </div>
    </div>
    <div  class='text-center'>
        <button class='btn btn-primary w-25 mt-4 mb-2' type="submit">Valider</button>
        <button class='btn btn-primary w-25 mt-4 mb-2' onclick='annuler("bugreport");return false;'>Annuler</button>
    </div>
    {!! Form::close() !!}
</div>