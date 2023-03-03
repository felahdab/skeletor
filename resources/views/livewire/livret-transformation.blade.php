<div>
    <div wire:loading class="w-100">
        <div class="text-center">
            <div class="spinner-border" role="status">
                <span class="visually-hidden">Chargement...</span>
            </div>
        </div>
    </div>
    <div wire:loading.remove x-data="{ opendivvalid : false ,
                                        commentaire : '' ,
                                        valideur : '{{auth()->user()->display_name}}',
                                        date_validation : '{{ date('Y-m-d')}}',
                                        selected_compagnonnages : [],
                                        selected_taches : [],
                                        selected_objectifs : [],
                                        selected_sous_objectifs : [],
                                        selected_marins : [],
                                        readwrite : '{{ $readwrite }}'
                                        }"
                                        
                                        x-on:resetselection.window="selected_taches = [];
                                        selected_objectifs = [];
                                        selected_sous_objectifs = [];
                                        selected_marins = [];">
    

        <!-- div avec boutons generaux -->
        @include('livewire.livret-transformation.boutonsgeneraux')

        <!-- div avec formulaire de validation -->
        @include('livewire.livret-transformation.divvalid')

        
        <div id='livret' class='div-table-contrat-compagnonnage table'>
            @foreach ($fonctions as $fonction)
             <div class="accordion">
                <div class="accordion-item">
                    <div class="accordion-header bg-primary">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFonction_{{$fonction->id}}">
                            <h3>{{$fonction->fonction_liblong }} </h3>
                        </button>
                    </div>
                    <div id="collapseFonction_{{$fonction->id}}" class="accordion-collapse collapse">
                        <div  class="accordion-body">
                            @includeWhen($mode=='unique', 'livewire.livret-transformation.entetefonction')
                            
                            @if ($fonction->compagnonages->count() > 0)
                                @foreach($fonction->compagnonages as $compagnonage)
                                    @include('livewire.livret-transformation.compagnonage')
                               @endforeach <!-- foreach compagnonage -->
                            @endif
                            
                            @if ($mode == 'unique' && $fonction->stages->count() > 0)
                                @include('livewire.livret-transformation.stagefonction')
                            @endif
                            
                        </div>
                    </div>
                </div>
            </div>
            @endforeach   <!-- foreach fonction -->
            
            @if ($mode=='unique' && $user->getTransformationManager()->stages_orphelins()->count() > 0)
                @include('livewire.livret-transformation.stagesorphelins')
            @endif
        </div>  <!-- fin de la div livret -->
    </div>
</div>
