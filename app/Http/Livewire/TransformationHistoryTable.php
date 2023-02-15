<?php

namespace App\Http\Livewire;

use App\Models\TransformationHistory;
use App\Models\User;

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
            Column::make('Qui')
                ->label(
                    fn(TransformationHistory $row, Column $column) => view('tables.historytable.user', ['user' => TransformationHistory::find($row->id)->modifyinguser()->get()->first()])
                    )
                ->sortable()
                ->searchable(),
            Column::make('a fait quoi', 'event')
                ->sortable()
                ->searchable(),
            Column::make('Sur quelle partie de la transfo')
                ->label(
                    fn($row, Column $column) => view('tables.historytable.target')->withRow(TransformationHistory::find($row->id))
                    ),
            Column::make('de qui')
                ->label(
                    fn(TransformationHistory $row, Column $column) => view('tables.historytable.user', ['user' => TransformationHistory::find($row->id)->modifieduser()->get()->first()])
                    )
                ->sortable()
                ->searchable(),

        ];

        return $basecolumns;
    }

    public function filters(): array
    {
        return [
             TextFilter::make('Utilisateur agissant')
                ->config([
                    'placeholder' => '...'
                    ])
                ->filter(function(Builder $builder, string $value) {
                        $user = User::where('name', 'like', '%' . $value . '%')->get()->first();
                        if ($user != null)
                            $builder->where('modifying_user_id', $user->id);
                }),
            TextFilter::make('Utilisateur concerné')
                ->config([
                    'placeholder' => '...'
                    ])
                ->filter(function(Builder $builder, string $value) {
                        $user = User::where('name', 'like', '%' . $value . '%')->get()->first();
                        if ($user != null)
                            $builder->where('modified_user_id', $user->id);
                }),
        ];
    }
}