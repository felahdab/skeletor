<?php

namespace App\Filament\PageTemplates;

use BackedEnum;

use Filament\Pages\Page;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Schemas\Concerns\InteractsWithSchemas;
use Filament\Tables\Contracts\HasTable;
use Illuminate\Support\HtmlString;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Actions;
use Filament\Actions\Action;

use App\Models\AnnuaireUser;

class RechercheAnnuairePageTemplate extends Page implements HasTable
{
    use InteractsWithTable;
    use InteractsWithSchemas;

    protected static string | BackedEnum | null $navigationIcon = 'heroicon-o-magnifying-glass-circle';
    
    protected static ?string $title = 'Recherche dans l\'annuaire';

    protected $listeners = [
        'table-force-refresh' => '$refresh'
    ];

    protected string $view = 'filament.resources.annudef-user-resource.pages.recherche-annudef';

    public ?array $data;

    public function mount()
    {
        $this->form->fill();
    }

    public function form(Schema $form): Schema
    {
        return $form
            ->statePath('data')
            ->columns(4)
            ->components([
                TextInput::make('nom'),
                TextInput::make('prenom'),
                TextInput::make('email'),
                TextInput::make('unite'),
            ]);
    }

    public function submit()
    {
        $state = $this->form->getState();
        AnnuaireUser::setQuery($state);
        $this->dispatch('table-force-refresh');
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(AnnuaireUser::query())
            ->columns([
                TextColumn::make('nom')
                    ->sortable(),
                TextColumn::make('prenom')
                    ->sortable(),
                TextColumn::make('email')
                    ->sortable(),
                TextColumn::make('unite')
                    ->sortable(),
                TextColumn::make('nid')
                    ->sortable(),
                
            ])
            ->filters([
                // ...
            ])
            ->actions(
                $this->getRowActions()
            )
            ->bulkActions(
                $this->getBulkActions()
            )->headerActions([
                Action::make('submitAction')
                    ->label('Rechercher')
                    ->action(fn()=> $this->submit() )
            ]);
    }

    public function getRowActions()
    {
        return [];
    }

    public function getBulkActions()
    {
        return [];
    }

}
