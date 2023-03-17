<div>
    <div>
        <nav>
            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-table" type="button" role="tab" aria-controls="nav-home" aria-selected="true">Sélection</button>
                <button class="nav-link" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-fiches" type="button" role="tab" aria-controls="nav-home" aria-selected="true">Fiches bilan</button>
            </div>
        </nav>
        

        <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane show active" id="nav-table" role="tabpanel" aria-labelledby="nav-home-tab" tabindex="0"><livewire:users-table mode="dashboard"> </div>
            <div class="tab-pane" id="nav-fiches" role="tabpanel" tabindex="0">
                <button class="btn btn-primary" data-bs-target="#carouselDesFiches" data-bs-slide="prev">Précedent</button>
                <button class="btn btn-primary" data-bs-target="#carouselDesFiches" data-bs-slide="next">Suivant</button>
                <div id="carouselDesFiches" class="carousel slide" style='height: 400px;'>
                    <div class="carousel-inner">
                    @if(! is_null($fiches) && sizeof($fiches))
                        @foreach($fiches as $fiche)
                        <div class="carousel-item @if($loop->first) active @endif" >
                            <livewire:ffast-fiche-bilan :user="$fiche['user']" :wire:key="$fiche['id']" />
                        </div>
                        @endforeach
                    @endif
                </div>
            </div>     
            </div>
        </div>
    </div>
</div>