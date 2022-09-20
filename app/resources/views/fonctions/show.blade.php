@extends('layouts.app-master')

@section('content')
    <div class="bg-light p-4 rounded">
        <h2>Fonctions</h2>
        <div class="mt-2">
            @include('layouts.partials.messages')
        </div>
    </div>
    <div id='divmodifobj' class='card bg-light ml-3 w-100' >
        <div class='card-header' >Consulter fonction </div>
            <div style='padding-left: 15px;'>
                <div class='form-group row' >
                    <label for='fonction[fonction_libcourt]' class='col-sm-5 col-form-label'> Libell&eacute; court</label>
                    <div class='col-sm-5'>
                        <input type='text' class='form-control'  name='fonction[fonction_libcourt]' id='fonction[fonction_libcourt]' placeholder='Libell&eacute; court' value="{{ $fonction->fonction_libcourt }}" >
                    </div>
                </div>
                <div class='form-group row' >
                    <label for='fonction[fonction_liblong]' class='col-sm-5 col-form-label'>Libell&eacute; long</label>
                    <div class='col-sm-5'>
                        <input type='text' class='form-control' name='fonction[fonction_liblong]' id='fonction[fonction_liblong]' placeholder='Libell&eacute; long' value="{{ $fonction->fonction_liblong }}" >
                    </div>
                </div>
                <div class='form-group row' >
                    <label for='fonction[typefonction_id]' class='col-sm-5 col-form-label'>Type de fonction</label>
                    <div class='col-sm-5'>
                        <input type='text' class='form-control' name='fonction[typefonction_id]' id='fonction[typefonction_id]' placeholder='Type de fonction' value="{{ $fonction->type_fonction()->get()->first()->typfonction_libcourt }}" >
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
            </div>

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
            </div>
            @php $count = $count +1 @endphp
            @endforeach
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
            </div>
            @php $count = $count +1 @endphp
            @endforeach
        </div>
    </div>
@endsection