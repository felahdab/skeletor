<?php

namespace App\Filament\Resources\RemotesystemResource\RelationManagers;

use AxonC\FilamentCopyablePlaceholder\Forms\Components\CopyablePlaceholder;
use Carbon\Carbon;
use Filament\Actions\Action as FilamentAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class TokensRelationManager extends RelationManager
{
    protected static string $relationship = 'tokens';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required()
                    ->maxLength(255),
            ])
        ;
    }

    public function showtokenAction(): FilamentAction
    {
        return FilamentAction::make('token_created')
            ->modalHeading('Token créé')
            ->schema([
                CopyablePlaceholder::make('clear_text_token')
                    ->label('N\'oubliez pas de copier ce token: vous ne pourrez plus y accéder ensuite !')
                    ->content(function () {
                        return $this->getAction('token_created')->getArguments()['token'];
                    }),
            ])
            ->action(function () {
                return true;
            })
            ->modalSubmitActionLabel('Fermer')
            ->modalCancelAction(false)
        ;
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                TextColumn::make('name'),
                TextColumn::make('expires_at')->date(),
            ])
            ->filters([
            ])
            ->headerActions([
                // Tables\Actions\CreateAction::make(),

                FilamentAction::make('Nouveau token')
                    ->schema([
                        TextInput::make('name')
                            ->label('Nom du nouveau token')
                            ->default('token')
                            ->required(),
                        DatePicker::make('expires_at')
                            ->label('Date de fin de validite')
                            ->helperText('Si vous ne choisissez pas de date, le token sera valable indéfiniment.'),
                    ])
                    ->action(function (array $data) {
                        if (array_key_exists('expires_at', $data) && null != $data['expires_at']) {
                            $date = Carbon::parse($data['expires_at']);
                            $token = $this->getOwnerRecord()->createToken($data['name'], ['*'], $date);
                        } else {
                            $token = $this->getOwnerRecord()->createToken($data['name']);
                        }

                        $this->replaceMountedAction('showtoken', ['token' => $token->plainTextToken]);
                    }),
            ])
            ->recordActions([
                // Tables\Actions\EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
        ;
    }
}
