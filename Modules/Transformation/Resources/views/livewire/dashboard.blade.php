<div>
    <div>
        <nav>
            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-table" type="button" role="tab" aria-controls="nav-home" aria-selected="true">Sélection</button>
                @if(! is_null($charts) && sizeof($charts))
                    @foreach($charts as $chart)
                        <button class="nav-link" id="nav-{{ $chart['id'] }}-tab" data-bs-toggle="tab" data-bs-target="#nav-{{ $chart['id'] }}" type="button" role="tab" >{{ $chart['title'] }}</button>
                    @endforeach
                @endif
            </div>
        </nav>
        <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane show active" id="nav-table" role="tabpanel" aria-labelledby="nav-home-tab" tabindex="0"><livewire:transformation::users-table mode="dashboard"> </div>
            @if(! is_null($charts) && sizeof($charts))
                @foreach($charts as $chart)
                    <div class="tab-pane" id="nav-{{ $chart['id'] }}" role="tabpanel" tabindex="0">
                        <div style='height: 400px;'>    
                            @if ( $chart['type'] == 'livewire-column-chart')
                                <livewire:livewire-column-chart :column-chart-model="$chart['data']"  key="{{ $loop->index . now() }}"/>
                            @elseif ( $chart['type'] == 'livewire-area-chart')
                                <livewire:livewire-area-chart :area-chart-model="$chart['data']" key="{{  $loop->index . now() }}"/>
                            @elseif ( $chart['type'] == 'livewire-line-chart')
                                <livewire:livewire-line-chart :line-chart-model="$chart['data']" key="{{  $loop->index . now() }}"/>
                            @elseif ( $chart['type'] == 'livewire-multi-column-chart')
                                <livewire:livewire-multi-column-chart :column-chart-model="$chart['data']" key="{{  $loop->index . now() }}"/>
                            @elseif ( $chart['type'] == 'livewire-multi-line-chart')
                                <livewire:livewire-multi-line-chart :line-chart-model="$chart['data']" key="{{  $loop->index . now() }}"/>
                            @elseif ( $chart['type'] == 'livewire-pie-chart')
                                <livewire:livewire-pie-chart :pie-chart-model="$chart['data']" key="{{  $loop->index . now() }}"/>
                            @elseif ( $chart['type'] == 'livewire-radar-chart')
                                <livewire:livewire-radar-chart :radar-chart-model="$chart['data']" key="{{  $loop->index . now() }}"/>
                            @elseif ( $chart['type'] == 'livewire-tree-map-chart')
                                <livewire:livewire-tree-map-chart :tree-map-chart-model="$chart['data']" key="{{  $loop->index . now() }}"/>
                            @endif                    
                        </div>        
                    </div>
                @endforeach
            @endif
        </div>
    </div>
</div>