<?php

namespace Modules\Transformation\Http\Livewire;

use Modules\Transformation\Entities\MiseEnVisibilite;
use App\Models\Unite;
use Modules\Transformation\Entities\User;

use Rappasoft\LaravelLivewireTables\Views\Columns\LinkColumn;
use Rappasoft\LaravelLivewireTables\Views\Columns\BooleanColumn;
use Rappasoft\LaravelLivewireTables\Views\Columns\ButtonGroupColumn;
use Rappasoft\LaravelLivewireTables\Views\Filters\TextFilter;
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

class MiseenvisibiliteTable extends DataTableComponent

{
    public function builder(): Builder
    {
        return MiseEnVisibilite::query()
        ->whereHas('user', function (Builder $query) {
            $query->where('deleted_at', null);
        });
        
    }
    
    public function configure(): void
    {
        $this->setPrimaryKey('id');
    }
    
    public function mpeActions()
    {
        return view('transformation::tables.miseenvisibilitetable.gestion');
    }
    
    public function columns(): array
    {
        $basecolumns = [
            Column::make('ID', 'id')
                ->sortable()
                ->searchable()
                ->deselected(),
            Column::make('Debut', 'date_debut')
                ->sortable()
                ->searchable(),
            Column::make('Fin', 'date_fin')
                ->sortable()
                ->searchable(),
            Column::make('Unite', 'unite.unite_libcourt')
                ->sortable()
                ->searchable(),
            Column::make('User', 'user.display_name')
                ->sortable()
                ->searchable(),
            Column::make('Actions')
                ->label(
                    fn($row, Column $column) => $this->mpeActions()->withRow($row)
                    ),
];
        return $basecolumns;

    }
}