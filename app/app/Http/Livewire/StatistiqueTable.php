<?php

namespace App\Http\Livewire;

use App\Models\Statistique;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Columns\LinkColumn;
use Rappasoft\LaravelLivewireTables\Views\Columns\BooleanColumn;
use Rappasoft\LaravelLivewireTables\Views\Columns\ButtonGroupColumn;
use Rappasoft\LaravelLivewireTables\Views\Filters\TextFilter;
use Rappasoft\LaravelLivewireTables\Views\Filters\SelectFilter;

use Illuminate\Database\Eloquent\Builder;

use Illuminate\Support\Carbon;


class StatistiqueTable extends DataTableComponent
{
    // protected $model = Statistique::class;
    public $period='';

    public function configure(): void
    {
        $this->setPrimaryKey('id');
        $this->setDefaultSort('date_debarq', 'asc');
    }
    public function builder(): Builder
    {
        $pieces = explode("-", $this->period);
        $date_stat = Carbon::create($pieces[0], $pieces[1], 1,0,0,0);
        $date_max = $date_stat->copy()->lastOfMonth();
        $date_min = $date_stat->copy()->firstOfMonth();
        return Statistique::query()
            ->where('date_debarq', '>', $date_min)
            ->where('date_debarq', '<=', $date_max);
    }
    public function columns(): array
    {
        return [
            Column::make("Id", "id")
                ->sortable()
                ->deSelected(),
            Column::make("Date stat", "date_stat")
                ->sortable()
                ->deSelected(),
            Column::make("Grade", "grade")
                ->sortable(),
            Column::make("Diplôme", "diplome")
                ->sortable(),
            Column::make("Spécialité", "specialite")
                ->sortable(),
            Column::make("Nom", "name")
                ->sortable()
                ->searchable(),
            Column::make("Prénom", "prenom")
                ->sortable(),
            Column::make("Date débarq", "date_debarq")
                ->sortable()
                ->searchable(),
            Column::make("Secteur", "secteur")
                ->sortable()
                ->searchable()
                ->deSelected(),
            Column::make("Service", "service")
                ->sortable()
                ->searchable(),
            Column::make("Gpmt", "gpmt")
                ->sortable()
                ->searchable(),
            Column::make("Tx stage", "taux_stage_valides")
                ->sortable()
                ->deSelected(),
            Column::make("Tx comp", "taux_comp_valides")
                ->sortable()
                ->deSelected(),
            Column::make("Tx transfo", "taux_de_transformation")
                ->sortable(),
            Column::make("Fonc quai", "nb_jour_pour_lache_quai")
                ->sortable(),
            Column::make("Fonc mer", "nb_jour_pour_lache_mer")
                ->sortable(),
            Column::make("Fonc metier", "nb_jour_pour_lache_metier")
                ->sortable(),
            Column::make("Nb jours", "nb_jour_gtr")
                ->sortable(),
        ];
    }
}
