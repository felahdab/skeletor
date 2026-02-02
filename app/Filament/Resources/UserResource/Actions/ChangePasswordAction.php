<?php

namespace App\Filament\Resources\UserResource\Actions;

use Filament\Actions\Action;
use Filament\Forms\Components;

class ChangePasswordAction extends Action
{
    public static function make(?string $name = null): static
    {
        return parent::make($name)
            ->label("Changer le mot de passe")
            ->requiresConfirmation()
            ->visible(fn($record) => auth()->user()->IsSuperAdmin() || (! $record->IsSuperAdmin() && auth()->user()->can('skeletor.changer_le_mot_de_passe_des_utilisateurs')))
            ->form([
                Components\TextInput::make('password')
                    ->label('Mot de passe')
                    ->password()
                    ->revealable()
                    ->required()
                    ->minLength(8)
                    ->confirmed()
                    ->live(onBlur: true),

                Components\TextInput::make('password_confirmation')
                    ->label('Confirmez le mot de passe')
                    ->password()
                    ->revealable()
                    ->required()
                    ->live(onBlur: true),
            ])
            ->action(function($record, $data) {
                $validated = validator($data, [
                    'password' => ['required', 'string', 'min:8', 'confirmed'],
                ])->validate();
                
                $record->password = $validated['password'];
                $record->save();
            });
    }
}