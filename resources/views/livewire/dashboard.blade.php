<div style='height: 400px;' x-data="{ showTable : 'true' }">
    <div style='height: 100px; width: 20%;' class="btn btn-primary" x-on:click="showTable = ! showTable">Afficher la table/les graphiques</div>
    <div>
        <div x-show="showTable">
            <livewire:users-table mode="dashboard">        
        </div>
        @if(! is_null($charts) && sizeof($charts))
            @foreach($charts as $chart)
                <div style='height: 400px;' x-show="! showTable">    
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
            @endforeach
        @endif
    </div>
</div>