@extends('layouts.app-master')

@section('helplink')
< x-help-link page="parcours"/>
@endsection


@section('content')

    <div class="p-4 rounded">
        <h2>Mises pour emploi</h2>
        <div style='text-align:right;'>* champs obligatoires </div>
 
        
        {!! Form::open(['method' => 'PATCH','route' => ['transformation::miseenvisibilite.update', $miseenvisibilite->id] ]) !!}
        <div class="row mt-4"
        x-data='{
            hideshowdates() {
                if (document.getElementById("permanent").checked){
                    document.getElementById("datedeb").value = null;
                    document.getElementById("datedeb").disabled = true;
                    document.getElementById("datedeb").required = false;
                    document.getElementById("datefin").value = null;
                    document.getElementById("datefin").disabled = true;
                    document.getElementById("datefin").required = false;
                }
                else{
                    document.getElementById("datedeb").disabled = false;
                    document.getElementById("datedeb").required = true;
                    document.getElementById("datefin").disabled = false;
                    document.getElementById("datefin").required = true;
                }
            },
        }'>
            <div class="col">
                <label class="form-label">Marin</label>
                <input type="text" class="form-control" name="user" disabled value="{{$user->display_name}}">
            </div>
            <div class="col">
                <label class="form-label">Unité *</label>
                <select class="form-control" name="uniteid" id="uniteid" required  value="{{$miseenvisibilite->unite_id}}">
                    <option value="">Unité</option>
                    @foreach($unites as $unite)
                        <option value="{{ $unite->id }}" {{ $miseenvisibilite->unite_id == $unite->id ? ' selected' : '' }}>
                            {{ $unite->unite_libcourt }}
                        </option>
                    @endforeach
                </select>

                <div class="row"><div class="col-12">&nbsp;<br>&nbsp;</div></div>
                <div class="row"><div class="col-12">Durée *</div></div>
                <div class="row">
                    <div class="col-2">
                        <label class="form-label">Permanent</label>
                        <div class="form-check form-switch mt-2">
                            <x-form::checkbox name="permanent" value="1" x-on:click="hideshowdates()" :checked="$miseenvisibilite->sans_dates" />                        
                        </div>       
                    </div>
                    <div class="col-2"></div>
                    <div class="col-4">
                        <label class="form-label">Date de début</label>
                        @if ($miseenvisibilite->sans_dates)
                            <x-form::input name="datedeb" type="date" :value="$miseenvisibilite->date_debut" required  disabled/>
                        @else
                            <x-form::input name="datedeb" type="date" :value="$miseenvisibilite->date_debut" required/>
                        @endif
                    </div>
                    <div class="col-4">
                        <label class="form-label">Date de fin</label>
                        @if ($miseenvisibilite->sans_dates)
                            <x-form::input name="datefin" type="date" :value="$miseenvisibilite->date_fin" required  disabled/>
                        @else
                            <x-form::input name="datefin" type="date" :value="$miseenvisibilite->date_fin" required  />
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <button class='btn btn-primary ms-4 mt-4' type='submit' id='btnmodifobj' name='btnmodifobj'>Modifier</button>
        <a href="{{ route('transformation::miseenvisibilite.index') }}" class="btn btn-default mt-4">Annuler</a>
        {!! Form::close() !!}
    </div>
@endsection