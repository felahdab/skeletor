<?php

namespace App\Filament\Pages;

use App\Events\UnUtilisateurLocalDoitEtreCreeEvent;
use App\Events\UnUtilisateurLocalAEteCreeEvent;
use App\Filament\PageTemplates\RechercheAnnuairePageTemplate;
use App\Models\Role;
use Filament\Actions\Action;
use Filament\Actions\BulkAction;
use Filament\Forms\Components\Select;

class RechercheAnnuairePage extends RechercheAnnuairePageTemplate
{
    public static function canAccess(): bool
    {
        return auth()->check()
                && auth()->user()->can('skeletor.recherche-annuaire')
                && 'intradef' == config('skeletor.reseau_de_deploiement');
    }

    public function getRowActions()
    {
        return [
            Action::make('create-local-user')
                ->visible(function () {
                    return auth()->check() && auth()->user()->can('users.store');
                })
                ->icon('heroicon-o-plus')
                ->label("Créé l'utilisateur local")
                ->requiresConfirmation()
                ->schema([
                    Select::make('roles')
                        ->label('Rôles à attribuer')
                        ->options(Role::all()->pluck('name', 'id'))
                        ->multiple()
                        ->required(),
                ])
                ->action(function ($record, $data) {
                    UnUtilisateurLocalDoitEtreCreeEvent::dispatch($record->toArray(), $data['roles']);
                    UnUtilisateurLocalAEteCreeEvent::dispatch($record->toArray());
                }),
        ];
    }

    public function getBulkActions()
    {
        return [
            BulkAction::make('create-local-user')
                ->visible(function () {
                    return auth()->check() && auth()->user()->can('users.store');
                })
                ->icon('heroicon-o-plus')
                ->label("Créé l'utilisateur local")
                ->requiresConfirmation()
                ->schema([
                    Select::make('roles')
                        ->label('Rôles à attribuer')
                        ->options(Role::all()->pluck('name', 'id'))
                        ->multiple()
                        ->required(),
                ])
                ->action(function ($records, $data) {
                    foreach ($records as $record) {
                        UnUtilisateurLocalDoitEtreCreeEvent::dispatch($record->toArray(), $data['roles']);
                    }
                }),
        ];
    }
}
