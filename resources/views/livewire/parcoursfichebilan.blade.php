<div>
    <div>
        <nav>
            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-table" type="button" role="tab" aria-controls="nav-home" aria-selected="true">Sélection</button>
                @if(! is_null($fiches) && sizeof($fiches))
                    @foreach($fiches as $fiche)
                        <button class="nav-link" id="nav-{{ $fiche['id'] }}-tab" data-bs-toggle="tab" data-bs-target="#nav-{{ $fiche['id'] }}" type="button" role="tab" >{{ $fiche['title'] }}</button>
                    @endforeach
                @endif
            </div>
        </nav>
        <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane show active" id="nav-table" role="tabpanel" aria-labelledby="nav-home-tab" tabindex="0"><livewire:users-table mode="dashboard"> </div>
            @if(! is_null($fiches) && sizeof($fiches))
                @foreach($fiches as $fiche)
                    <div class="tab-pane" id="nav-{{ $fiche['id'] }}" role="tabpanel" tabindex="0">
                        <div style='height: 400px;'>    
                            <x-fichebilanng :user="$fiche['user']"/>
                        </div>        
                    </div>
                @endforeach
            @endif
        </div>
    </div>
</div>