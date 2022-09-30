<?php

namespace App\Http\Livewire;

use App\Models\User;
use App\Models\Grade;
use App\Models\Diplome;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;

use Rappasoft\LaravelLivewireTables\Views\Columns\LinkColumn;
use Rappasoft\LaravelLivewireTables\Views\Columns\ButtonGroupColumn;
use Rappasoft\LaravelLivewireTables\Views\Filters\TextFilter;
use Rappasoft\LaravelLivewireTables\Views\Filters\SelectFilter;

use Illuminate\Database\Eloquent\Builder;

class UsersTable extends DataTableComponent
{
    protected $model = User::class;
    
    public $mode='gestion';

    public function configure(): void
    {
        $this->setPrimaryKey('id');
        $this->setFilterLayout('slide-down');
    }

    public function userActions()
    {
        if ($this->mode == "gestion")
            return view('tables.userstable.gestion');
        elseif ($this->mode == "transformation")
            return view('tables.userstable.transformation');
    }

    public function columns(): array
    {
        return [
            Column::make('ID', 'id')
                ->sortable()
                ->searchable(),
            Column::make('Nom', 'name')
                ->sortable()
                ->searchable(),
            Column::make('Prénom', 'prenom')
                ->sortable()
                ->searchable(),
            Column::make('E-mail', 'email')
                ->sortable()
                ->searchable()
                ->deSelected(),
            Column::make('Grade', 'grade.grade_libcourt')
                ->searchable(),
            Column::make('Brevet', 'diplome.diplome_libcourt')
                ->searchable(),
            Column::make('Specialité', 'specialite.specialite_libcourt')
                ->searchable(),
            Column::make('Secteur', 'secteur.secteur_libcourt')
                ->searchable(),
            Column::make('Service', 'secteur.service.service_libcourt')
                ->searchable(),
            Column::make('Groupement', 'secteur.service.groupement.groupement_libcourt')
                ->searchable(),
            Column::make('Roles')
                ->label(
                    fn($row, Column $column) => view('tables.userstable.roles')->withRow($row)
                    ),
            Column::make('Actions')
                ->label(
                    fn($row, Column $column) => $this->userActions()->withRow($row)
                    ),
        ];
    }
    
    public function filters(): array
    {
        return [
             TextFilter::make('Grade')
                ->config([
                    'placeholder' => 'Grade...',
                    'maxlength'   => 4
                    ])
                ->filter(function(Builder $builder, string $value) {
                        $grade = Grade::where('grade_libcourt', 'like', '%' . $value . '%')->get()->first();
                        if ($grade != null)
                            $builder->where('grade_id', $grade->id);
                }),
            TextFilter::make('Brevet')
                ->config([
                    'placeholder' => 'Brevet...',
                    'maxlength'   => 4
                    ])
                ->filter(function(Builder $builder, string $value) {
                        $diplome = Diplome::where('diplome_libcourt', 'like', '%' . $value . '%')->get()->first();
                        if ($diplome != null)
                            $builder->where('diplome_id', $diplome->id);
                })
        ];
    }
}