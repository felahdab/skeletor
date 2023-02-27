<?php

namespace App\Http\Livewire;

use App\Models\TransformationHistory;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;

use Rappasoft\LaravelLivewireTables\Views\Columns\LinkColumn;
use Rappasoft\LaravelLivewireTables\Views\Columns\BooleanColumn;
use Rappasoft\LaravelLivewireTables\Views\Columns\ButtonGroupColumn;
use Rappasoft\LaravelLivewireTables\Views\Filters\TextFilter;
use Rappasoft\LaravelLivewireTables\Views\Filters\SelectFilter;

use Illuminate\Database\Eloquent\Builder;

class TransformationHistoryTable extends DataTableComponent
{
    // protected $model = TransformationHistory::class;

    public function builder(): Builder
    {
        return TransformationHistory::query()->orderBy('id', 'desc');
    }

    public $mode='gestion';
    public $targetuser = null;

    public function configure(): void
    {
        $this->setPrimaryKey('id');
        $this->setFilterLayoutSlideDown();
    }

    public function columns(): array
    {
        $basecolumns = [
            Column::make('ID', 'id')
                ->searchable(),
            Column::make('GDH', 'created_at'),
           Column::make('Qui', 'modifying_user')
                ->sortable()
                ->searchable(),
            Column::make('a fait quoi', 'event')
                ->sortable()
                ->searchable(),
            Column::make('Sur quelle partie de la transfo')
                ->label(
                    fn($row, Column $column) => view('tables.historytable.target')->withRow(TransformationHistory::find($row->id))
                    ),
            Column::make('de qui', 'modified_user')
                ->sortable()
                ->searchable(),

        ];

        return $basecolumns;
    }
}