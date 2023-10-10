<div>
    <nav>
        <div class="nav nav-tabs" id="nav-tab" role="tablist">
            <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-table" type="button" role="tab" aria-controls="nav-home" aria-selected="true">Sélection</button>
            @if(! is_null($mpes) && sizeof($mpes))
                <button class="nav-link" id="nav-result-tab" data-bs-toggle="tab" data-bs-target="#nav-planning" type="button" role="tab" >Planning</button>
            @endif
        </div>
    </nav>
    <div class="tab-content" id="nav-tabContent">
        <div class="tab-pane show active" id="nav-table" role="tabpanel" aria-labelledby="nav-home-tab" tabindex="0"><livewire:transformation::miseenvisibilite-planning-table></div>
            @if(! is_null($mpes) && sizeof($mpes))
                <div class="tab-pane" id="nav-planning" role="tabpanel" tabindex="0">
                    <livewire:transformation::planning-mpe :mpes='$mpes' key="{{  now() }}"/>
                </div>
            @endif
        </div>
</div>
