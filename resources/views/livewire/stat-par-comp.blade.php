<div x-data = {}>
    <div wire:loading.remove x-data="{ opendivvalid : false ,
                                        commentaire : '' ,
                                        valideur : '{{htmlspecialchars(auth()->user()->display_name)}}',
                                        date_validation : '{{ date('Y-m-d')}}',
                                        selected_parcomp : [],
                                        readwrite : true,
                                       }"
                                        
                                        x-on:resetselection.window="selected_parcomp = [];">
    <div>
        <nav>
            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                <button class="nav-link @if( ! $tabresult) active @endif" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-table" type="button" role="tab" aria-controls="nav-home" aria-selected="true">Sélection</button>
                <button class="nav-link @if($tabresult) active @endif" id="nav-fiche-tab" data-bs-toggle="tab" data-bs-target="#nav-fiches" type="button" role="tab" aria-controls="nav-home" aria-selected="true">Résultat</button>
            </div>
        </nav>
    </div>        
    <div class="tab-content" id="nav-tabContent">
        <div class="tab-pane @if(! $tabresult) show  active @endif" id="nav-table" role="tabpanel" aria-labelledby="nav-home-tab" tabindex="0">
            <livewire:transformation::compagnonage-table>
        </div>
        <div class="tab-pane @if($tabresult) show  active @endif" id="nav-fiches" role="tabpanel" tabindex="0">
            @if ($comp)
                <livewire:etat-comp-users :comp="$comp"  :wire:key="$comp->id">
            @endif
        </div>
    </div>
    <div @display-comp.window="$wire.selectComp($event.detail.comp);"></div>
</div>