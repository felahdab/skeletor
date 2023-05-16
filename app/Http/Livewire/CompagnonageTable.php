<?php

namespace App\Http\Livewire;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Compagnonage;

class CompagnonageTable extends DataTableComponent
{
    protected $model = Compagnonage::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id');
        $this->setFilterLayoutSlideDown();
        $this->setDefaultSort('comp_libcourt', 'asc');
    }

    public function columns(): array
    {
        return [
            Column::make("Id", "id")
                ->sortable()
                ->deSelected(),
            Column::make("Libellé court", "comp_libcourt")
                ->sortable()
                ->searchable(),
            Column::make("Libellé long", "comp_liblong")
                ->sortable()
                ->searchable(),
            Column::make('Actions')
                ->label(
                    fn($row, Column $column) => $this->userActions()->withRow($row)
                    ),
        ];
    }
    public function userActions()
    {
        return view('tables.stattable.boutoncomp');
    }

}
