<?php

namespace App\Livewire;

use App\Models\User;
use App\Models\Unite;
use App\Models\Grade;
use App\Models\Diplome;
use App\Models\Specialite;
use App\Models\Secteur;
use App\Models\Service;
use App\Models\Groupement;
use Spatie\Permission\Models\Role;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;

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

use Barryvdh\Debugbar\Facades\Debugbar;

class UsersTable extends DataTableComponent
{
    // protected $model = User::class;

    public function builder(): Builder
    {
        switch ($this->mode) {
            case "archiv":
                $userlist = User::withTrashed()
                    ->whereNotNull('users.deleted_at');  // qui ont ete supprime depuis la liste des utilisateurs
                return $userlist;
                break;
            default:
                return User::query();
                break;
        }
    }

    public $mode = 'gestion';
    public $fonction = null;
    public $userids = null;

    public function configure(): void
    {
        $this->setPrimaryKey('users.id');
        $this->setFilterLayoutSlideDown();
        $this->setDefaultSort('name', 'asc');
        $this->setTableAttributes([
            'default' => false,
            'class' => 'table table-hover',
        ]);
    }

    public function userActions()
    {
        switch ($this->mode) {
            case "gestion":
                return view('tables.userstable.gestion');
                break;
            case "archiv":
                return view('tables.userstable.archives');
                break;
        }
    }

    public function columns(): array
    {
        $basecolumns = [
            Column::make('Grade', 'grade.grade_libcourt')
                ->searchable(),
            // Column::make('Brevet', 'diplome.diplome_libcourt')
            Column::make('Orga-FCM', 'diplome.diplome_libcourt')
                ->searchable(),
            Column::make('Spécialité', 'specialite.specialite_libcourt')
                ->searchable(),
            Column::make('ID', 'id')
                ->sortable()
                ->searchable()
                ->deSelected(),
            Column::make('Nom', 'name')
                ->sortable()
                ->searchable(),
            Column::make('Prénom', 'prenom')
                ->sortable()
                ->searchable(),
            Column::make('Matricule', 'matricule')
                ->deSelected()
                ->searchable(),
            Column::make('NID', 'nid')
                ->deSelected()
                ->searchable(),
            Column::make('E-mail', 'email')
                ->sortable()
                ->searchable()
                ->deSelected(),
            // Column::make('Secteur', 'secteur.secteur_libcourt')
                Column::make('FPS-rattach', 'secteur.secteur_libcourt')
                ->searchable(),
            Column::make('Service', 'secteur.service.service_libcourt')
                ->searchable()
                ->deSelected(),
            Column::make('Groupement', 'secteur.service.groupement.groupement_libcourt')
                ->searchable()
                ->deSelected(),
            Column::make('U-actuelle', 'unite_id')
                ->sortable()
                ->format(
                    fn ($value, $row, Column $column) => view('tables.userstable.libunite')->withRow($row)
                ),
            Column::make('U-dest', 'unite_destination.unite_libcourt')
                ->sortable()
                ->searchable()
                ->deSelected(),
            Column::make('Rôles')
                ->label(
                    fn ($row, Column $column) => view('tables.userstable.roles')->withRow($row)
                ),
        ];
        switch ($this->mode) {
            case "gestion":
                return array_merge($basecolumns, [
                    Column::make('Actions')
                        ->label(
                            fn ($row, Column $column) => $this->userActions()->withRow($row)
                        ),
                ]);
                break;
            case "archiv":
                return array_merge($basecolumns, [
                    Column::make('Supprimé', 'deleted_at')
                        ->deSelected(),
                    Column::make('Actions')
                        ->label(
                            fn ($row, Column $column) => $this->userActions()->withRow($row)
                        ),
                ]);
                break;
            default:
                return $basecolumns;
                break;
        }
    }

    public function filters(): array
    {
        $basefilters = [
            TextFilter::make('Grade')
                ->config([
                    'placeholder' => 'SM...',
                    'maxlength'   => 3
                ])
                ->filter(function (Builder $builder, string $value) {
                    $grade = Grade::where('grade_libcourt', 'like', '%' . $value . '%')->get()->first();
                    if ($grade != null)
                        $builder->where('grade_id', $grade->id);
                }),
            TextFilter::make('Orga-FCM')
                ->config([
                    'placeholder' => 'BAT...',
                    'maxlength'   => 50
                ])
                ->filter(function (Builder $builder, string $value) {
                    $diplome = Diplome::where('diplome_libcourt', 'like', '%' . $value . '%')->get()->first();
                    if ($diplome != null)
                        $builder->where('diplome_id', $diplome->id);
                }),
            TextFilter::make('Spé')
                ->config([
                    'placeholder' => 'SECNAV...',
                    'maxlength'   => 15
                ])
                ->filter(function (Builder $builder, string $value) {
                    $specialite = Specialite::where('specialite_libcourt', 'like', $value . '%')->get()->first();
                    if ($specialite != null)
                        $builder->where('specialite_id', $specialite->id);
                }),
            TextFilter::make('FPS-Rattach')
                ->config([
                    'placeholder' => 'DEM...',
                    'maxlength'   => 50
                ])
                ->filter(function (Builder $builder, string $value) {
                    $secteur = Secteur::where('secteur_libcourt', 'like', $value . '%')->get()->first();
                    if ($secteur != null)
                        $builder->where('secteur_id', $secteur->id);
                }),
            TextFilter::make('U-actuelle')
                ->config([
                    'placeholder' => 'LGC...',
                    'maxlength'   => 50
                ])
                ->filter(function (Builder $builder, string $value) {
                    $unite = Unite::where('unite_libcourt', 'like', '%' . $value . '%')
                        ->orWhere('unite_liblong', 'like', '%' . $value . '%')
                        ->get()->pluck('id');
                    if ($unite != null)
                        $builder->whereIn('unite_id', $unite);
                }),
            TextFilter::make('U-dest')
                ->config([
                    'placeholder' => 'LGC...',
                    'maxlength'   => 5
                ])
                ->filter(function (Builder $builder, string $value) {
                    $unite = Unite::where('unite_libcourt', 'like', '%' . $value . '%')->get()->pluck('id');
                    if ($unite != null)
                        $builder->whereIn('unite_destination_id', $unite);
                }),
        ];
        return $basefilters;
    }

    public function render(): \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
    {
        $this->userids = $this->getCurrentItems();
        $this->dispatch("userListUpdated", $this->userids);
        return parent::render();
    }

    public function getCurrentItems()
    {
        return (clone $this->baseQuery())->pluck($this->getPrimaryKey())->map(fn ($item) => (string)$item)->toArray();
    }
}
