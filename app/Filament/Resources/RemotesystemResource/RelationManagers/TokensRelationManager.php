<?php

namespace App\Filament\Resources\RemotesystemResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Carbon\Carbon;
use Filament\Actions\Modal\Actions\Action;
use Filament\Notifications\Notification;
use AxonC\FilamentCopyablePlaceholder\Forms\Components\CopyablePlaceholder;

use Filament\Actions\Action as FilamentAction;

class TokensRelationManager extends RelationManager
{
    protected static string $relationship = 'tokens';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
            ]);
    }


    public function showtokenAction():FilamentAction {
        return FilamentAction::make('token_created')
            ->modalHeading('Token créé')
            ->form([
                CopyablePlaceholder::make('clear_text_token')
                                    ->label('N\'oubliez pas de copier ce token: vous ne pourrez plus y accéder ensuite !')
                                    ->content(function() { 
                                        return $this->getAction('token_created')->getArguments()['token'];
                                    })
            ])
            ->action(function (array $arguments) {
                return true;           
            })
            ->modalSubmitActionLabel('Fermer')
            ->modalCancelAction(false);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                Tables\Columns\TextColumn::make('name'),
                Tables\Columns\TextColumn::make('expires_at')->date(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                //Tables\Actions\CreateAction::make(),
                
                Tables\Actions\Action::make('Nouveau token')
                    ->form([
                        TextInput::make("name")
                            ->label("Nom du nouveau token")
                            ->default("token")
                            ->required(),
                        DatePicker::make("expires_at")
                            ->label("Date de fin de validite")
                            ->helperText("Si vous ne choisissez pas de date, le token sera valable indéfiniment.")

                    ])
                    ->action(function (array $data) {
                        if (array_key_exists("expires_at", $data) && $data["expires_at"] != null){
                            $date = Carbon::parse($data["expires_at"]);
                            $token = $this->getOwnerRecord()->createToken($data["name"], ['*'], $date);
                        }
                        else 
                            $token = $this->getOwnerRecord()->createToken($data["name"]);

                        $this->replaceMountedAction('showtoken', ["token" => $token->plainTextToken]);
                    })
            ])
            ->actions([
               // Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
