<div>
    <div>
        <nav>
            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-table" type="button" role="tab" aria-controls="nav-home" aria-selected="true">Sélection</button>
                <button class="nav-link" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-fiches" type="button" role="tab" aria-controls="nav-home" aria-selected="true">Fiches bilan</button>
            </div>
        </nav>
        

        <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane show active" id="nav-table" role="tabpanel" aria-labelledby="nav-home-tab" tabindex="0"><livewire:transformation::users-table mode="dashboard"> </div>
            <div class="tab-pane" id="nav-fiches" role="tabpanel" tabindex="0">
                
                <div id="carouselDesFiches" class="carousel slide" style='height: 400px;'>
                    <div class="carousel-inner">
                    @if(! is_null($fiches) && sizeof($fiches))
                        @foreach($fiches as $fiche)                        
                        <div class="carousel-item @if($loop->first) active @endif mt-4" >
                            <div class="row">
                                <div class="col-sm-1">
                                    <button class="btn btn-default" data-bs-target="#carouselDesFiches" data-bs-slide="prev" style="height: 100%;">
                                        <svg fill="currentColor" viewBox="0 0 16 16">
                                            <path fill-rule="evenodd" d="M11.354 1.646a.5.5 0 0 1 0 .708L5.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0z"/>
                                        </svg>
                                    </button>
                                </div>
                                <div class="col-sm-10">
                                    <a href="{{ route('transformation::transformation.livret', $fiche['user']->id) }}" class="btn btn-warning btn-sm">PPA du marin</a>
                                    <a href="{{ route('transformation::transformation.progression', $fiche['user']->id) }}" class="btn btn-primary btn-sm">Progression</a>
                                    @can('transformation::users.stages')
                                        <a href="{{ route('transformation::users.stages', $fiche['user']->id) }}" class="btn btn-danger btn-sm">Stages</a>
                                    @endcan
                            
                                    <livewire:transformation::ffast-fiche-bilan :user="$fiche['user']" :wire:key="$fiche['id']"  mode="parcours"/>
                                </div>
                                <div class="col-sm-1">
                                    <button class="btn btn-default" data-bs-target="#carouselDesFiches" data-bs-slide="next" style="height: 100%;">
                                        <svg fill="currentColor" class="bi bi-chevron-right" viewBox="0 0 16 16">
                                            <path fill-rule="evenodd" d="M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 2.354a.5.5 0 0 1 0-.708z"/>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    @endif
                    </div>
                                        
                </div>     
            </div>
        </div>
    </div>
</div>