<?php

namespace App\Filament\PageTemplates;

use App\Models\AnnuaireUser;
use Filament\Actions\Action;
use Filament\Forms\Components\TextInput;
use Filament\Pages\Page;
use Filament\Schemas\Concerns\InteractsWithSchemas;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;

class RechercheAnnuairePageTemplate extends Page implements HasTable
{
    use InteractsWithTable;
    use InteractsWithSchemas;

    public ?array $data;

    protected static \BackedEnum|string|null $navigationIcon = 'heroicon-o-magnifying-glass-circle';

    protected static ?string $title = 'Recherche dans l\'annuaire';

    protected $listeners = [
        'table-force-refresh' => '$refresh',
    ];

    protected string $view = 'filament.resources.annudef-user-resource.pages.recherche-annudef';

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
            ])
        ;
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
                    ->action(fn () => $this->submit()),
            ])
        ;
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
