<?php

namespace Modules\Transformation\Http\Livewire;

use Modules\Transformation\Entities\MiseEnVisibilite;
use App\Models\Unite;
use Modules\Transformation\Entities\User;
use App\Models\Secteur;
use App\Models\Service;
use App\Models\Groupement;

use Rappasoft\LaravelLivewireTables\Views\Columns\LinkColumn;
use Rappasoft\LaravelLivewireTables\Views\Columns\BooleanColumn;
use Rappasoft\LaravelLivewireTables\Views\Columns\ButtonGroupColumn;
use Rappasoft\LaravelLivewireTables\Views\Filters\TextFilter;
use Rappasoft\LaravelLivewireTables\Views\Filters\DateFilter;
use Rappasoft\LaravelLivewireTables\Views\Filters\SelectFilter;
use Rappasoft\LaravelLivewireTables\Views\Filters\MultiSelectFilter;
use Rappasoft\LaravelLivewireTables\Views\Filters\MultiSelectDropdownFilter;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

use Barryvdh\Debugbar\Facades\Debugbar;

use Modules\Transformation\Scopes\MemeUnite;

use Livewire\Component;

class MiseenvisibilitePlanningTable extends DataTableComponent
{
    public function builder(): Builder
    {
        return MiseEnVisibilite::query();
    }
    
    public function configure(): void
    {
        $this->setPrimaryKey('id');
        $this->setFilterLayoutSlideDown();
    }
        
    public function columns(): array
    {
        $basecolumns = [
            Column::make('ID', 'id')
                ->sortable()
                ->searchable()
                ->deselected(),
            Column::make('Marin', 'user.display_name')
                ->sortable()
                ->searchable(),
            Column::make('Début', 'date_debut')
                ->sortable()
                ->searchable(),
            Column::make('Fin', 'date_fin')
                ->sortable()
                ->searchable(),
            Column::make('Unité', 'unite.unite_libcourt')
                ->sortable()
                ->searchable(),
            Column::make('Secteur', 'user.secteur.secteur_libcourt')
                ->searchable(),
            Column::make('Service', 'user.secteur.service.service_libcourt')
                ->searchable(),
            Column::make('Groupement', 'user.secteur.service.groupement.groupement_libcourt')
                ->searchable(),
        ];
        return $basecolumns;

    }
    public function filters(): array
    {
        $filter = [
            TextFilter::make('Unité')
                ->config([
                    'placeholder' => 'LGC_A',
                    'maxlength'   => 20
                    ])
                ->filter(function(Builder $builder, string $value) {
                    $unite = Unite::where('unite_libcourt', 'like', $value . '%')->get()->pluck('id');
                    if ($unite != null)
                        $builder->whereIn('transformation_mise_en_visibilites.unite_id', $unite);
            }),
            TextFilter::make('Secteur')
                ->config([
                    'placeholder' => 'DEM...',
                    'maxlength'   => 50
                    ])
                ->filter(function(Builder $builder, string $value) {
                        $secteur = Secteur::where('secteur_libcourt', 'like', $value . '%')->get()->first();
                        if ($secteur != null)
                            $builder->where('secteur_id', $secteur->id);
            }),
            TextFilter::make('Service')
                ->config([
                    'placeholder' => 'LAS...',
                    'maxlength'   => 5
                    ])
                ->filter(function(Builder $builder, string $value) {
                        $service = Service::where('service_libcourt', 'like', $value . '%')->get()->first();
                        if ($service != null)
                            $builder->where('service_id', $service->id);
            }),
            TextFilter::make('Gpmt')
                ->config([
                    'placeholder' => 'NAV...',
                    'maxlength'   => 5
                    ])
                ->filter(function(Builder $builder, string $value) {
                        $gpmt = Groupement::where('groupement_libcourt', 'like', $value . '%')->get()->first();
                        if ($gpmt != null)
                            $builder->where('groupement_id', $gpmt->id);
            }),
            DateFilter::make('Date début')
                ->filter(function(Builder $builder, string $value) {
                        $builder->where('date_debut','>=', $value);
            }),
            DateFilter::make('Date fin')
                ->filter(function(Builder $builder, string $value) {
                        $builder->where('date_fin','<=', $value);
            }),
        ];
        return $filter;
    }
    
    public function render(): \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
    {
        $this->planningids = $this->getCurrentItems();
        $this->emitUp("planningUpdated" , $this->planningids);
        return parent::render();
    }
    
    public function getCurrentItems()
    {
        return (clone $this->baseQuery())->pluck($this->getPrimaryKey())->map(fn ($item) => (string)$item)->toArray();
    }



}
