<?php

namespace App\Http\Livewire;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;

use App\Models\Service;
use App\Models\Groupement;

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

class ServicesTable extends DataTableComponent
{
    protected $model = Service::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id');
        $this->setFilterLayoutSlideDown();
        $this->setDefaultSort('id', 'asc');
    }

    public function builder(): Builder
    {
        return Service::query();
    }

    public function serviceActions()
    {
        return view('tables.servicestable.gestion');
    }

    public function columns(): array
    {
        return [
            Column::make("Id", "id")
                ->sortable()
                ->searchable()
                ->deSelected(),
            Column::make("Libellé court", "service_libcourt")
                ->searchable()
                ->sortable(),
            Column::make("Libellé long", "service_liblong")
                ->searchable()
                ->sortable(),
            Column::make("Libellé court", "groupement.groupement_libcourt")
                ->searchable()
                ->sortable(),
            Column::make("Libellé long", "groupement.groupement_liblong")
                ->searchable()
                ->sortable(),
            Column::make('Actions')
                    ->label(
                        fn($row, Column $column) => $this->serviceActions()->withRow($row)
                        ),
        ];
    }

    public function filters(): array
    {
        $basefilters= [
            
            TextFilter::make('Service')
                ->config([
                    'placeholder' => 'LAS...',
                    'maxlength'   => 5
                    ])
                ->filter(function(Builder $builder, string $value) {
                        $service = Service::where('service_libcourt', 'like', $value . '%')->get()->first();
                        if ($service != null)
                            $builder->where('id', $service->id);
                }),

            TextFilter::make('Groupement')
                ->config([
                    'placeholder' => 'NAV...',
                    'maxlength'   => 5
                    ])
                ->filter(function(Builder $builder, string $value) {
                        $gpmt = Groupement::where('groupement_libcourt', 'like', $value . '%')->get()->first();
                        if ($gpmt != null)
                            $builder->where('groupement_id', $gpmt->id);
                }),
        ];
        return $basefilters;
    }

}
