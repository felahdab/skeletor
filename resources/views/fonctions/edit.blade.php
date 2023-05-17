@extends('layouts.app-master')

@section('helplink')
< x-help-link page="parcours"/>
@endsection


@section('content')
    <div class="p-4 rounded">
        <h2>Fonctions</h2>
    </div>
    <div id='divmodifobj' class='card ml-3 w-100' >
        <div class='card-header' >Modification fonction </div>
        <div style='text-align:right;'>* champs obligatoires </div>
        {!! Form::open(['method' => 'PATCH','route' => ['fonctions.update', $fonction->id] ]) !!}
            <input type='hidden' id='fonction[id]' name='fonction[id]' value='{{ $fonction->id }}'>
            <div style='padding-left: 15px;'>
                <div class='form-group row' >
                    <label for='fonction[fonction_libcourt]' class='col-sm-5 col-form-label'> Libell&eacute; court *</label>
                    <div class='col-sm-5'>
                        <input type='text' maxlength='100' class='form-control'  name='fonction[fonction_libcourt]' id='fonction[fonction_libcourt]' placeholder='Libell&eacute; court' value="{{ $fonction->fonction_libcourt }}" >
                    </div>
                </div>
                <div class='form-group row' >
                    <label for='fonction[fonction_liblong]' class='col-sm-5 col-form-label'>Libell&eacute; long *</label>
                    <div class='col-sm-5'>
                        <input type='text' maxlength='256' class='form-control' name='fonction[fonction_liblong]' id='fonction[fonction_liblong]' placeholder='Libell&eacute; long' value="{{ $fonction->fonction_liblong }}" >
                    </div>
                </div>
                <div class="form-group row">
                    <label for="typefonction_id" class="col-sm-5 col-form-label">Type de fonction *</label>
                    <div class='col-sm-5'>
                        <select class="form-control" 
                            name="fonction[typefonction_id]" required>
                            <option value="0">Type de fonction</option>
                            @foreach($typefonctions as $typefonction)
                                <option value="{{ $typefonction->id }}" {{ $fonction->typefonction_id == $typefonction->id
                                        ? ' selected'
                                        : '' }}>
                                    {{ $typefonction->typfonction_libcourt }}
                                    {{ $fonction->typefonction_id == $typefonction->id
                                        ? ' (type actuel)'
                                        : '' }}  </option>
                            @endforeach
                        </select>
                        @if ($errors->has('grade'))
                            <span class="text-danger text-left">{{ $errors->first('grade') }}</span>
                        @endif
                    </div>
                </div>
                <div class='form-group row' >
                    <label for='fonction_lache' class='col-sm-5 col-form-label'>Lâcher</label>
                    <div class='col-sm-5'>
                        <input type='checkbox'name='fonction[fonction_lache]' id='fonction[fonction_lache]' {{ $fonction->fonction_lache
                                            ? ' checked'
                                            : '' }}> 
                    </div>
                </div>
                <div class='form-group row' >
                    <label for='fonction_double' class='col-sm-5 col-form-label'>Double</label>
                    <div class='col-sm-5'>
                        <input type='checkbox'name='fonction[fonction_double]' id='fonction[fonction_double]' {{ $fonction->fonction_double
                                            ? ' checked'
                                            : '' }}> 
                    </div>
                </div>
                <div>
                    <button class='btn btn-primary mt-4' type='submit' id='btnmodifobj' name='btnmodifobj'>Modifier</button>
                    <a href="{{ route('fonctions.index') }}" class="btn btn-default mt-4">Annuler</a>
                    <br>&nbsp;
                </div>
            </div>
        {!! Form::close() !!}

        <div style='padding-left: 15px;'>
            <div class='card-header ml-n3 mr-n4 mb-3' >Compagnonnage(s) associ&eacute;(s)</div>
            <input type='hidden' name='fonction_id' id='fonction_id'  value='{{ $fonction->id }}'>
            
            @php $count = 1 @endphp
            @foreach ($fonction->compagnonages()->get() as $compagnonage)
            <div class='cadressobj'>
            <div class='form-group row' >
                <label class='col-sm-5 col-form-label '>Compagnonnage </label>
            </div>
            <div class='form-group row' >
                <label class='col-sm-5 col-form-label '>Libellé court</label>
                <div class='col-sm-5'>
                    <input type='text' class='form-control' name='compagnonages[{{$count}}][comp_libcourt]' id='compagnonages[{{$count}}][comp_libcourt]' placeholder='Libellé court' value='{{ $compagnonage->comp_libcourt }}'>
                </div>
            </div>
            <div class='form-group row' >
                <label class='col-sm-5 col-form-label '>Libellé long</label>
                <div class='col-sm-5'>
                    <input type='text' class='form-control' name='compagnonages[{{$count}}][comp_libclong]' id='compagnonages[{{$count}}][comp_libclong]' placeholder='Libellé long' value='{{ $compagnonage->comp_liblong }}'>
                </div>
            </div>
            @can("fonctions.removecompagnonage")
            {!! Form::open(['method' => 'POST','route' => ['fonctions.removecompagnonage', $fonction ],'style'=>'display:inline']) !!}
            <input type='hidden' name='compagnonage_id' id='compagnonage_id'  value='{{ $compagnonage->id }}'>
            {!! Form::submit('Retirer ce compagnonnage', ['class' => 'btn btn-danger btn-sm']) !!}
            {!! Form::close() !!}
            @endcan
            </div>
            @php $count = $count +1 @endphp
            @endforeach
            
            @can("fonctions.choisircompagnonage")
            <div style='text-align: center;'>
                {!! Form::open(['method' => 'GET','route' => ['fonctions.choisircompagnonage', $fonction->id],'style'=>'display:inline']) !!}
                {!! Form::submit('Ajouter un nouveau compagnonnage', ['class' => 'btn btn-primary btn-sm']) !!}
                {!! Form::close() !!}
            </div>
            @endcan
        </div>
        <div style='padding-left: 15px;'>
            <div class='card-header ml-n3 mr-n4 mb-3' >Stage(s) associ&eacute;(s)</div>
            <input type='hidden' name='fonction_id' id='fonction_id'  value='{{ $fonction->id }}'>
            
            @php $count = 1 @endphp
            @foreach ($fonction->stages()->get() as $stage)
            <div class='cadressobj'>
            <div class='form-group row' >
                <label class='col-sm-5 col-form-label '>Stage </label>
            </div>
            <div class='form-group row' >
                <label class='col-sm-5 col-form-label '>Libellé court</label>
                <div class='col-sm-5'>
                    <input type='text' class='form-control' name='stages[{{$count}}][stage_libcourt]' id='stages[{{$count}}][stage_libcourt]' placeholder='Libellé court' value='{{ $stage->stage_libcourt }}'>
                </div>
            </div>
            <div class='form-group row' >
                <label class='col-sm-5 col-form-label '>Libellé long</label>
                <div class='col-sm-5'>
                    <input type='text' class='form-control' name='stages[{{$count}}][stage_liblong]' id='stages[{{$count}}][stage_liblong]' placeholder='Libellé long' value='{{ $stage->stage_liblong }}'>
                </div>
            </div>
            @can("fonctions.removestage")
            {!! Form::open(['method' => 'POST','route' => ['fonctions.removestage', $fonction ],'style'=>'display:inline']) !!}
            <input type='hidden' name='stage_id' id='stage_id'  value='{{ $stage->id }}'>
            {!! Form::submit('Retirer ce stage', ['class' => 'btn btn-danger btn-sm']) !!}
            {!! Form::close() !!}
            @endcan
            </div>
            @php $count = $count +1 @endphp
            @endforeach
            
            @can("fonctions.choisirstage")
            <div style='text-align: center;'>
                {!! Form::open(['method' => 'GET','route' => ['fonctions.choisirstage', $fonction->id],'style'=>'display:inline']) !!}
                {!! Form::submit('Ajouter un nouveau stage', ['class' => 'btn btn-primary btn-sm']) !!}
                {!! Form::close() !!}
            </div>
            @endcan
        </div>
    </div>
@endsection