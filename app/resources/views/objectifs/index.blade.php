@extends('layouts.app-master')

@section('content')

    <div class="bg-light p-4 rounded">
        <h2>Objectifs</h2>
        <div class="lead">
            Gérer les objectifs.
        </div>
        
        <div class="mt-2">
            @include('layouts.partials.messages')
        </div>
		{{ $objectifs->count()  }}

    </div>
	<div id='divmodifobj' class='card bg-light ml-3 w-100' >
<div class='card-header' >Modification objectif </div>
<div style='text-align:right;'>* champs obligatoires </div>
<form method='post' id ='formmodifobj' action='#' style='padding: 20px; position: relative; right: 20px; ' enctype='multipart/form-data'>
<div style='padding-left: 15px;'>
	<div class='form-group row' >
		<label for ='listobjs' class='col-sm-5 col-form-label'> Objectif </label>
		<select name='listobjs' id='listobjs' class='custom-select  w-50' onchange='modifparam("param2","listobjs");'>
				@foreach ($objectifs as $objectif)
					<option value="{{$objectif->id}}" > {{ $objectif->objectif_liblong }} </option>
				@endforeach
		</select>
	</div>
</div>
<div style='padding-left: 15px;'>
	<div class='form-group row' >
		<label for='objlibc' class='col-sm-5 col-form-label'> Libell&eacute; court *</label>
		<div class='col-sm-5'>
			<input type='text' class='form-control'  name='objlibc' id='objlibc' placeholder='Libell&eacute; court' value="test" >
			</div>
		</div>
		<div class='form-group row' >
			<label for='objlibl' class='col-sm-5 col-form-label'>Libell&eacute; long</label>
			<div class='col-sm-5'>
				<input type='text' class='form-control' name='objlibl' id='objlibl' placeholder='Libell&eacute; long' value="test" >
				</div>
			</div>
			<div style='text-align:right;'>
				<ul  class='navbar-nav mr-auto' >
					<li class='nav-item dropdown'>
						<a href='#' class='nav-link dropdown-toogle' data-toggle='dropdown'>T&acirc;che(s) associée(s)</a>
						<ul class='dropdown-menu dropdown-menu-right'></ul>
					</li>
				</ul>
			</div>
			<div>
				<button class='btn btn-primary w-100 mt-4' type='submit' form='formmodifobj' id='btnmodifobj' name='btnmodifobj'>Modifier</button>
				<br>&nbsp;
				</div>
			</div>
			<div style='padding-left: 15px;'>
				<div class='card-header ml-n3 mr-n4 mb-3' >Sous-objectifs associ&eacute;s</div>
				<div class='cadressobj'>
					<div class='form-group row' >
						<label class='col-sm-5 col-form-label '>Sous-objectif </label>
						<div class='col-sm-5'>
							<textarea cols='40' rows='6' name='listssobjobj1' id='listssobjobj1' placeholder='Libell&eacute;' >test</textarea>
						</div>
					</div>
					<div class='form-group row' >
						<label class='col-sm-5 col-form-label '>Coefficient</label>
						<div class='col-sm-5'>
							<input type='text' class='form-control' name='ssobjcoef1' id='ssobjcoef1' placeholder='Coefficient' value='1.00'>
							</div>
						</div>
						<div class='form-group row' >
							<label class='col-sm-5 col-form-label '>Dur&eacute;e (heure)</label>
							<div class='col-sm-5'>
								<input type='text' class='form-control' name='ssobjduree1' id='ssobjduree1' placeholder='Durée' value='1.00'>
								</div>
							</div>
							<div class='form-group row' >
								<label class='col-sm-5 col-form-label '>Lieu </label>
								<div class='col-sm-5'>
									<select name='listlieux1' id='listlieux1' class='custom-select  w-50'>
										<option value ='2' selected >1Bord</option>
										<option value ='3' >2GTR</option>
										<option value ='9' >ALFAN</option>
										<option value ='6' >CFPES</option>
										<option value ='7' >ESCO</option>
										<option value ='8' >EXT</option>
										<option value ='5' >GTR et Bord</option>
										<option value ='4' >GTR ou Bord</option>
										<option value ='1' >PEM</option>
									</select>
								</div>
							</div>
						</div>
						<div style='text-align: center;'>
							<button id='btnajoutssobjobj' class='btn btn-primary' style='font-size: 20pt;' name='btnajoutssobjobj' title='ajouter un sous objectif'>+</button>
						</div>
						<div>
							<button class='btn btn-primary w-100 mt-4' type='submit' form='formmodifobj' id='btnmodifobjssobj' name='btnmodifobjssobj'>Modifier les sous objectifs associ&eacute;s</button>
						</div>
					</div>
				</form>
			</div>
@endsection