<?php

namespace App\Http\Livewire;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;

use App\Models\Secteur;
use App\Models\Service;

use Rappasoft\LaravelLivewireTables\Views\Columns\LinkColumn;
use Rappasoft\LaravelLivewireTables\Views\Columns\BooleanColumn;
use Rappasoft\LaravelLivewireTables\Views\Columns\ButtonGroupColumn;
use Rappasoft\LaravelLivewireTables\Views\Filters\TextFilter;
use Rappasoft\LaravelLivewireTables\Views\Filters\SelectFilter;
use Rappasoft\LaravelLivewireTables\Views\Filters\MultiSelectFilter;
use Rappasoft\LaravelLivewireTables\Views\Filters\MultiSelectDropdownFilter;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class SecteursTable extends DataTableComponent
{
    protected $model = Secteur::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id');
        $this->setFilterLayoutSlideDown();
        $this->setDefaultSort('id', 'asc');
    }

    public function builder(): Builder
    {
        return Secteur::query();
    }

    public function secteurActions()
    {
        return view('tables.secteurstable.gestion');
    }

    public function columns(): array
    {
        return [
            Column::make("Id", "id")
                ->sortable()
                ->searchable()
                ->deSelected(),
            Column::make("Libellé court", "secteur_libcourt")
                ->searchable()
                ->sortable(),
            Column::make("Libellé long", "secteur_liblong")
                ->searchable()
                ->sortable(),
            Column::make("Libellé court", "service.service_libcourt")
                ->searchable()
                ->sortable(),
            Column::make("Libellé long", "service.service_liblong")
                ->searchable()
                ->sortable(),
            Column::make('Actions')
                    ->label(
                        fn($row, Column $column) => $this->secteurActions()->withRow($row)
                        ),
        ];
    }

    public function filters(): array
    {
        $basefilters= [
            
            TextFilter::make('Secteur')
                ->config([
                    'placeholder' => 'LAS...',
                    'maxlength'   => 5
                    ])
                ->filter(function(Builder $builder, string $value) {
                        $secteur = Secteur::where('secteur_libcourt', 'like', $value . '%')->get()->first();
                        if ($secteur != null)
                            $builder->where('id', $secteur->id);
                }),

            // TextFilter::make('Service')
            //     ->config([
            //         'placeholder' => 'NAV...',
            //         'maxlength'   => 5
            //         ])
            //     ->filter(function(Builder $builder, string $value) {
            //             $gpmt = Service::where('service_libcourt', 'like', $value . '%')->get()->first();
            //             if ($gpmt != null)
            //                 $builder->where('service_id', $gpmt->id);
            //     }),
        ];
        return $basefilters;
    }

}
