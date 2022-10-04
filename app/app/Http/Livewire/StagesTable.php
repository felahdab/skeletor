<?php

namespace App\Http\Livewire;

use App\Models\Stage;
use App\Models\User;
use App\Models\TypeLicence;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;

use Rappasoft\LaravelLivewireTables\Views\Columns\LinkColumn;
use Rappasoft\LaravelLivewireTables\Views\Columns\ButtonGroupColumn;
use Rappasoft\LaravelLivewireTables\Views\Filters\TextFilter;
use Rappasoft\LaravelLivewireTables\Views\Filters\SelectFilter;

use Illuminate\Database\Eloquent\Builder;

class StagesTable extends DataTableComponent
{
    protected $model = Stage::class;
    
    public $mode='gestion';
    public $user=null;

    public function builder(): Builder
    {
        if ($this->mode == "uservalidation")
        {
            $stagelist = $this->user->stages()->get()->pluck('id', 'id');
            return Stage::query()->whereIn('stages.id', $stagelist);
        }
        return Stage::query();
    }

    public function configure(): void
    {
        $this->setPrimaryKey('id');
        $this->setFilterLayoutSlideDown();
    }

    public function stageActions()
    {
        if ($this->mode == "gestion")
            return view('tables.stagestable.gestion');
        elseif ($this->mode == "transformation")
            return view('tables.stagestable.transformation');
        elseif ($this->mode == "uservalidation")
            return view('tables.stagestable.uservalidation', ['user' => $this->user]);
    }

    public function columns(): array
    {
        return [
            Column::make('ID', 'id')
                ->sortable()
                ->searchable(),
            Column::make('Libelle court', 'stage_libcourt')
                ->sortable()
                ->searchable(),
            Column::make('Libelle long', 'stage_liblong')
                ->sortable()
                ->searchable(),
            Column::make('Licence', 'type_licence.typlicense_libcourt')
                ->searchable(),
            Column::make('Actions')
                ->label(
                    fn($row, Column $column) => $this->stageActions()->withRow($row)
                    ),
        ];
    }
    
    public function filters(): array
    {
        return [
             TextFilter::make('Licence')
                ->config([
                    'placeholder' => '1...',
                    'maxlength'   => 3
                    ])
                ->filter(function(Builder $builder, string $value) {
                        $typelic = TypeLicence::where('typlicense_libcourt', 'like', '%' . $value . '%')->get()->first();
                        if ($typelic != null)
                            $builder->where('typelicence_id', $typelic->id);
                }),
            // TextFilter::make('Brevet')
                // ->config([
                    // 'placeholder' => 'BAT...',
                    // 'maxlength'   => 3
                    // ])
                // ->filter(function(Builder $builder, string $value) {
                        // $diplome = Diplome::where('diplome_libcourt', 'like', '%' . $value . '%')->get()->first();
                        // if ($diplome != null)
                            // $builder->where('diplome_id', $diplome->id);
                // })
        ];
    }
    
    public function UnvalidateStage(User $user, Stage $stage)
    {
        $workitem = $user->stages()->find($stage)->pivot;
        $workitem->date_validation = null;
        $workitem->commentaire = null;
        $workitem->save();
    }
    
    public function ValidateStage(User $user, Stage $stage, $commentaire, $date_validation)
    {
        $workitem = $user->stages()->find($stage)->pivot;
        $workitem->date_validation = $date_validation;
        $workitem->commentaire = $commentaire;
        $workitem->save();
    }
}