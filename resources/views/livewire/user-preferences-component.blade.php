<div x-data="{'daily_fonctions'  : false,
            'weekly_fonctions'   : false,
            'fonctions_collapse' : $wire.entangle('fonctions_collapse'),
            'selected_fonctions' : [],
            'daily_services'     : false,
            'weekly_services'    : false,
            'selected_services'  : [],
            'services_collapse'  : $wire.entangle('services_collapse')
        }">
    <h2 class="mt-4"> Préférences </h2>

    <h3 class="mt-4"> Page d'accueil </h3>
    <div class="card mt-4">
        <div class="card-header">
            Choix de la page d'accueil
        </div>
        <div class="card-body">
            <div>Sélectionnez ci-dessous la page que vous souhaitez afficher lorsque vous venez de vous connecter. 
            </div>
            <div class="mt-4">
                <select class="form-select form-select-lg mb-3" aria-label=".form-select-lg example" wire:model="settings.transformation.pageaccueil">
                    @foreach($prefered_routes as $libelle => $route)
                        @can("{{ $route }}")
                            <option value="{{ $route }}">{{ $libelle }}</option>
                        @endcan
                   @endforeach
                </select>
            </div>
        </div>
    </div>

    @can('transformation::notifications.lache_fonction')
    <h3 class="mt-4"> Notifications </h3>
    
    
    <div class="card mt-4">
        <div class="card-header">
            Notifications relatives aux fonctions
        </div>
        <div class="card-body">
            <div>Sélectionnez ci-dessous les fonctions pour lesquelles vous souhaitez être prévenu lorsqu'un marin est lâché. <br>
                Vous serez vous même prévenu si vous êtes lâché dans une de vos fonctions, même si celle-ci n'est pas sélectionnée ci-dessous.
            </div>
            @if(false)
            <div>
            <input type='checkbox' 
                wire:model="settings.transformation.notifications.pour_fonctions.daily"> Notifications quotidiennes
            </div>
            <div>
            <input type='checkbox' 
                wire:model="settings.transformation.notifications.pour_fonctions.weekly"> Notifications hebdomadaires
            </div>
            @endif
            <div class="accordion  mt-4">
                <div class="accordion-item">
                    <div class="accordion-header bg-primary">
                        <button class="accordion-button" 
                                x-on:click="fonctions_collapse = ! fonctions_collapse"
                                :class="fonctions_collapse ? 'collapsed': ''" 
                                type="button" 
                                data-bs-toggle="collapse" 
                                data-bs-target="#accordeon_fonctions">
                            <h3> Fonctions </h3>
                        </button>
                    </div>
                    <div id="accordeon_fonctions" class="accordion-collapse" :class="fonctions_collapse ? 'collapse': 'show'">
                        <div  class="accordion-body">
                            @foreach($fonctions as $fonction)
                            <div class="row">
                                <div class="col-sm-1 form-switch">           
                                    <input type='checkbox'  class="form-check-input"
                                    x-on:click="services_collapse=true; fonctions_collapse=false"
                                    wire:model="settings.transformation.notifications.pour_fonctions.liste_fonctions.{{ $fonction->id }}"
                                        value="{{$fonction->id}}">
                                </div>
                                <div class="col-sm-3">
                                    {{ $fonction->fonction_libcourt }}
                                </div> 
                                <div class="col-sm-8">
                                    {{ $fonction->fonction_liblong }}
                                </div>       
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @if(false)
    <div class="card mt-4"">
        <div class="card-header">
            Notifications relatives aux services
        </div>
        <div class="card-body">
            <div>
            <input type='checkbox' 
                wire:model="settings.transformation.notifications.pour_services.daily"> Notifications quotidiennes
            </div>
            <div>
            <input type='checkbox' 
                wire:model="settings.transformation.notifications.pour_services.weekly"> Notifications hebdomadaires
            </div>
            <div class="accordion mt-4">
                <div class="accordion-item">
                    <div class="accordion-header bg-primary">
                        <button class="accordion-button" 
                            x-on:click="services_collapse = ! services_collapse"
                            :class="services_collapse ? 'collapsed': ''" 
                            type="button" 
                            data-bs-toggle="collapse" 
                            data-bs-target="#accordeon_services">
                            <h3> Services </h3>
                        </button>
                    </div>
                    <div id="accordeon_services" class="accordion-collapse" :class="services_collapse ? 'collapse': 'show'">
                        <div  class="accordion-body">
                            @foreach($services as $service)
                            <div class="form-switch">           
                                <input type='checkbox'  class="form-check-input"
                                    x-on:click="services_collapse=false; fonctions_collapse=true"
                                    wire:model="settings.transformation.notifications.pour_services.liste_services.{{ $service->id }}"
                                    value="{{$service->id}}" />
                                {{ $service->service_libcourt }}
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
    @endcan
</div>
