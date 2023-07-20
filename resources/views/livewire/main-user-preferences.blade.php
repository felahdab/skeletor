<div>
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
                <select class="form-select form-select-lg mb-3" aria-label=".form-select-lg example" wire:model="settings.prefered_page">
                    @foreach($listpagesaccueil as $libelle => $route)
                        @can($route)
                            <option value="{{ $route }}">{{ $libelle }}</option>
                        @endcan
                @endforeach
                </select>
            </div>
        </div>
    </div>

    <livewire:transformation::user-preferences-component/>
</div>
