<?php

namespace App\Livewire;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;

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

class GroupementTable extends DataTableComponent
{
    protected $model = Groupement::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id');
        $this->setFilterLayoutSlideDown();
        $this->setDefaultSort('id', 'asc');
    }

    public function builder(): Builder
    {
        return Groupement::query();
    }

    public function groupementActions()
    {
        return view('tables.groupementtable.gestion');
    }

    public function columns(): array
    {
        return [
            Column::make("Id", "id")
                ->sortable()
                ->searchable()
                ->deSelected(),
            Column::make("Libellé court", "groupement_libcourt")
                ->searchable()
                ->sortable(),
            Column::make("Libellé long", "groupement_liblong")
                ->searchable()
                ->sortable(),
            Column::make('Actions')
                    ->label(
                        fn($row, Column $column) => $this->groupementActions()->withRow($row)
                        ),
        ];
    }

    public function filters(): array
    {
        $basefilters= [
            
            TextFilter::make('groupement')
                ->config([
                    'placeholder' => 'LAS...',
                    'maxlength'   => 5
                    ])
                ->filter(function(Builder $builder, string $value) {
                        $groupement = groupement::where('groupement_libcourt', 'like', $value . '%')->get()->first();
                        if ($groupement != null)
                            $builder->where('id', $groupement->id);
                }),
        ];
        return $basefilters;
    }

}
