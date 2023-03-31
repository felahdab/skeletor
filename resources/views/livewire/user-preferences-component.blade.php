<div x-data="{'daily_fonctions'  : false,
            'weekly_fonctions'   : false,
            'selected_fonctions' : [],
            'daily_services'     : false,
            'weekly_services'    : false,
            'selected_services'  : []}">
    <h2> Préférences </h2>

    <h3> Notifications </h3>

    <h4> Notifications relatives aux fonctions </h4>
    <div>
    <input type='checkbox' 
        wire:model="settings.ffast.notifications.pour_fonctions.daily"> Notifications quotidiennes
    <div>
    </div>
    <input type='checkbox' 
        wire:model="settings.ffast.notifications.pour_fonctions.weekly"> Notifications hebdomadaires
    </div>
    <div class="accordion">
        <div class="accordion-item">
            <div class="accordion-header bg-primary">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#accordeon_fonctions">
                    <h3> Fonctions </h3>
                </button>
            </div>
            <div id="accordeon_fonctions" class="accordion-collapse collapse">
                <div  class="accordion-body">
                    @foreach($fonctions as $fonction)
                    <div>           
                        <input type='checkbox' 
                        wire:model="settings.ffast.notifications.pour_fonctions.liste_fonctions.{{ $fonction->id }}"
                            value="{{$fonction->id}}">
                        {{ $fonction->fonction_libcourt }}
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>


    <h4> Notifications relatives aux services </h4>
    <div>
    <input type='checkbox' 
        wire:model="settings.ffast.notifications.pour_services.daily"> Notifications quotidiennes
    </div>
    <div>
    <input type='checkbox' 
        wire:model="settings.ffast.notifications.pour_services.weekly"> Notifications hebdomadaires
    </div>
    <div class="accordion">
        <div class="accordion-item">
            <div class="accordion-header bg-primary">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#accordeon_services">
                    <h3> Services </h3>
                </button>
            </div>
            <div id="accordeon_services" class="accordion-collapse collapse">
                <div  class="accordion-body">
                    @foreach($services as $service)
                    <div>
                        <input type='checkbox' 
                            wire:model="settings.ffast.notifications.pour_services.liste_services.{{ $service->id }}"
                            value="{{$service->id}}" />
                        {{ $service->service_libcourt }}
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
