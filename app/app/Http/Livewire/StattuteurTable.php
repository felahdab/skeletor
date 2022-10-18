<?php

namespace App\Http\Livewire;

use App\Models\User;
use App\Models\Grade;
use App\Models\Diplome;
use App\Models\Secteur;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;

use Rappasoft\LaravelLivewireTables\Views\Columns\LinkColumn;
use Rappasoft\LaravelLivewireTables\Views\Columns\BooleanColumn;
use Rappasoft\LaravelLivewireTables\Views\Columns\ButtonGroupColumn;
use Rappasoft\LaravelLivewireTables\Views\Filters\TextFilter;
use Rappasoft\LaravelLivewireTables\Views\Filters\SelectFilter;

use Illuminate\Database\Eloquent\Builder;

class StattuteurTable extends DataTableComponent
{
    protected $model = User::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id');
        $this->setTableRowUrl(function($row) {
            return route('transformation.livret', $row);
        });
        $this->setPaginationStatus(false);
        $this->setFilterLayoutSlideDown();
        $this->setDefaultSort('name', 'asc');
    }

    public function builder(): Builder
    {
        $service_id=auth()->user()->service->id;
        
        return User::query()
                  ->join ('secteurs', 'secteurs.id', '=', 'users.secteur_id')
                  ->where('secteurs.service_id', $service_id)
                  ->WhereExists(function($maquery){
                      $maquery->select ('id')
                                ->from ('user_fonction')
                                ->whereColumn('user_fonction.user_id', 'users.id')
                  ;})
                 ;
    }

    public function columns(): array
    {
        
        return [
            Column::make("Id", "id")
                ->deSelected()
                ->sortable(),
            Column::make('Grade', 'grade.grade_libcourt')
                ->searchable(),
            Column::make("Nom", "name")
                ->sortable()
                ->searchable(),
            Column::make("Prénom", "prenom")
                ->searchable(),
            Column::make('Brevet', 'diplome.diplome_libcourt')
                ->deSelected()
                ->searchable(),
            Column::make('Specialite', 'specialite.specialite_libcourt')
                ->deSelected()
                ->searchable(),
            Column::make('Groupement', 'secteur.service.groupement.groupement_libcourt')
                ->deSelected()
                ->searchable(),
            Column::make('Service', 'secteur.service.service_libcourt')
                ->deSelected()
                ->searchable(),
            Column::make('Secteur', 'secteur.secteur_libcourt')
                ->searchable(),
            Column::make('Fonction à quai')
                ->label(
                    fn($row, Column $column) => view('tables.stattable.foncquai', ['marin' => $row])
                    )
                ->searchable(),
            Column::make('Fonction à la mer')
                ->label(
                    fn($row, Column $column) => view('tables.stattable.foncmer', ['marin' => $row])
                    )
                ->searchable(),
            Column::make('Fonction métier')
                ->label(
                    fn($row, Column $column) => view('tables.stattable.foncmetier', ['marin' => $row])
                    )
                ->searchable(),
            Column::make("Tx transfo", "taux_de_transformation")
                ->sortable()
                ->searchable(), 
         ];
    }
    public function filters(): array
    {
        return [
             TextFilter::make('Secteur')
                ->config([
                    'placeholder' => 'RESEAU...',
                    'maxlength'   => 10
                    ])
                ->filter(function(Builder $builder, string $value) {
                        $secteur = Secteur::where('secteur_libcourt', 'like', '%' . $value . '%')->get()->first();
                        if ($secteur != null)
                            $builder->where('secteur_id', $secteur->id);
                }),
            // TextFilter::make('Fonction')
                // ->config([
                    // 'placeholder' => 'GRADE...',
                    // 'maxlength'   => 15
                    // ])
                // ->filter(function(Builder $builder, string $value) {
                        // $fonction = Fonction::where('fonction_libcourt', 'like', '%' . $value . '%')->get()->first();
                        // if ($fonction != null)
                            // $builder->where('fonction_id', $fonction->id);
                // })
        ];
    }
}
