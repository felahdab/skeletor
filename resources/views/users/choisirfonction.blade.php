@extends('layouts.app-master')

@section('helplink')
< x-help-link page="transformation"/>
@endsection


@section('content')
    <div class="  p-4 rounded">
        <h1>Attribution des fonctions à l'utilisateur</h1>
        <h3>{{ $user->display_name }}</h3>

        {!! Form::open(['method' => 'POST','route' => ['users.attribuerfonction', $user->id]]) !!}
        {{-- <label for="fonction" class="form-label">Fonction</label> --}}
        <select class="form-select w-50 mt-4" 
            name="fonction_id" required>
            <option value="0">Sélectionnez la fonction à attribuer</option>
            @foreach($fonctions as $fonction)
                <option value="{{ $fonction->id }}">
                    {{ $fonction->fonction_liblong }}
                    </option>
            @endforeach
        </select>
        <div class="btn-group mt-3" role="groupe">
            {!! Form::button('Attribuer cette fonction', ['type'=> 'submit', 'class'=>'btn btn-primary']) !!}
            {!! Form::close() !!}
            <a href="{{ route('transformation.index') }}" class="btn btn-outline-dark"> Annuler </button>
            <a href="{{ route('transformation.livret', $user->id) }}" class="btn btn-warning">Livret de transformation</a>
        </div>
        
        <div class="container mt-4">
            <div style='padding-left: 15px;'>
                <div class="d-flex flex-row mb-3 justify-content-between">
                    <div class="p-2 w-50">Fonction(s) attribu&eacute;e(s)</div>
                    <div class="p-2 w-25">Type</div>
                    <div class="p-2 w-25">Action</div>
                </div>
                                  
                @php $count = 1 @endphp
                @foreach ($user->fonctions()->get() as $fonction)
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex flex-row mb-1 d-flex justify-content-between">
                            <div class="p-2 w-50">
                                @if ($fonction->pivot->date_lache != null)
                                    <span class="text-success"><x-bootstrap-icon iconname='check-circle.svg'/>&nbsp;</span>
                                @endif
                                <span class="card-title h4">{{ $fonction->fonction_liblong }}</span><span class="card-text"> => {{ $fonction->fonction_libcourt }} </span>
                                <h6 class="card-subtitle mb-2 text-body-secondary mt-1">Taux de transformation : {{ $fonction->pivot->taux_de_transformation }} %</h6>        
                            </div>
                            <div class="p-2 w-25">
                                <h6 class="card-subtitle mb-2 text-body-secondary mt-1">{{ $fonction->type_fonction()->get()->first()->typfonction_liblong }}</h6>        
                            </div>
                            <div class="p-2 w-25">
                                {!! Form::open(['method' => 'POST','route' => ['users.retirerfonction', $user->id]]) !!}
                                <input type='hidden' id='fonction_id' name='fonction_id' value='{{ $fonction->id }}'>
                                {!! Form::button('Retirer cette fonction', ['type'=> 'submit', 'class'=>'btn btn-danger btn-sm']) !!}
                                {!! Form::close() !!}    
                            </div>
                        </div>
                    </div>
                </div>
               @php $count = $count +1 @endphp
                @endforeach                
            </div>
        </div>
    </div>
@endsection