<?php

namespace App\Http\Livewire;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;

use App\Models\Archive;

use Rappasoft\LaravelLivewireTables\Views\Columns\LinkColumn;
use Rappasoft\LaravelLivewireTables\Views\Columns\BooleanColumn;
use Rappasoft\LaravelLivewireTables\Views\Columns\ButtonGroupColumn;
use Rappasoft\LaravelLivewireTables\Views\Filters\TextFilter;
use Rappasoft\LaravelLivewireTables\Views\Filters\DateFilter;
use Rappasoft\LaravelLivewireTables\Views\Filters\SelectFilter;
use Rappasoft\LaravelLivewireTables\Views\Filters\MultiSelectFilter;
use Rappasoft\LaravelLivewireTables\Views\Filters\MultiSelectDropdownFilter;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;

class DashboardarchiveTable extends DataTableComponent
{
    protected $model = Archive::class;
    
    public function builder(): Builder
    {
        return Archive::query();
    }

    public function configure(): void
    {
        $this->setPrimaryKey('id');
        $this->setFilterLayoutSlideDown();
        $this->setDefaultSort('name', 'asc');
    }

    public function columns(): array
    {
        return [
            Column::make("Id", "id")
                ->sortable()
                ->searchable()
                ->deSelected(),
            Column::make('Grade', 'userdata->grade')
                ->searchable()
                ->sortable(),
            Column::make('Brevet', 'userdata->brevet')
                ->searchable()
                ->sortable(),
            Column::make('Spécialité', 'userdata->specialite')
                ->searchable()
                ->sortable(),
            Column::make('Nom', 'name')
                ->sortable()
                ->searchable(),
            Column::make('Prénom', 'prenom')
                ->sortable()
                ->searchable(),
            Column::make('Matricule', 'matricule')
                ->deSelected()
                ->searchable()
                ->deSelected(),
            Column::make('NID', 'nid')
                ->deSelected()
                ->searchable()
                ->deSelected(),
            Column::make('E-mail', 'email')
                ->sortable()
                ->searchable()
                ->deSelected(),
            Column::make('Date emb', 'userdata->date_emb')
                ->searchable()
                ->sortable(),
            Column::make('Date déb', 'userdata->date_deb')
                ->searchable()
                ->sortable(),
            Column::make('Tx transfo', 'userdata->tx_transfo')
                ->searchable()
                ->sortable(),
            Column::make('Nb jours', 'userdata->nb_jour_presence')
                ->searchable()
                ->sortable(),        
        ];
    }
    public function filters(): array
    {
        $basefilters= [
            DateFilter::make('Début')
                ->filter(function(Builder $builder, string $value) {
                    $builder->where('userdata->date_deb', '>=', $value);
                }),
            DateFilter::make('Fin')
                ->filter(function(Builder $builder, string $value) {
                    $builder->where('userdata->date_deb', '<=', $value);
                }),
            TextFilter::make('Grade')
                ->config([
                    'placeholder' => 'SM...',
                    'maxlength'   => 3
                    ])
                ->filter(function(Builder $builder, string $value) {
                        $builder->where('userdata->grade', 'like', '%'.$value.'%');
                }),
            TextFilter::make('Brevet')
                ->config([
                    'placeholder' => 'SM...',
                    'maxlength'   => 3
                    ])
                ->filter(function(Builder $builder, string $value) {
                        $builder->where('userdata->brevet', 'like', '%'.$value.'%');
                }),
            TextFilter::make('Spécialité')
                ->config([
                    'placeholder' => 'SM...',
                    'maxlength'   => 3
                    ])
                ->filter(function(Builder $builder, string $value) {
                        $builder->where('userdata->specialite', 'like', '%'.$value.'%');
                }),
        ];
        return $basefilters;
    }
    public function render()
    {
        $this->archiveids = $this->getCurrentItems();
        $this->emitUp("archiveListUpdated", $this->archiveids);
        return parent::render();
    }
    
    public function getCurrentItems()
    {
        return (clone $this->baseQuery())->pluck($this->getPrimaryKey())->map(fn ($item) => (string)$item)->toArray();
    }

}
