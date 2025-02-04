<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MindefConnectUserResource\Pages;
use App\Filament\Resources\MindefConnectUserResource\RelationManagers;
use App\Models\MindefConnectUser;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class MindefConnectUserResource extends Resource
{
    protected static ?string $model = MindefConnectUser::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('email')
                    ->email()
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('nom')
                    ->required()
                    ->maxLength(255)
                    ->default(''),
                Forms\Components\TextInput::make('prenom')
                    ->required()
                    ->maxLength(255)
                    ->default(''),
                Forms\Components\TextInput::make('main_department_number')
                    ->required()
                    ->maxLength(255)
                    ->default(''),
                Forms\Components\TextInput::make('personal_title')
                    ->required()
                    ->maxLength(255)
                    ->default(''),
                Forms\Components\TextInput::make('rank')
                    ->required()
                    ->maxLength(255)
                    ->default(''),
                Forms\Components\TextInput::make('short_rank')
                    ->required()
                    ->maxLength(255)
                    ->default(''),
                Forms\Components\TextInput::make('display_name')
                    ->required()
                    ->maxLength(255)
                    ->default(''),
                Forms\Components\TextInput::make('commentaire')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('sub')
                    ->maxLength(255)
                    ->default(null),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('nom')
                    ->searchable(),
                Tables\Columns\TextColumn::make('prenom')
                    ->searchable(),
                Tables\Columns\TextColumn::make('main_department_number')
                    ->searchable(),
                Tables\Columns\TextColumn::make('personal_title')
                    ->searchable(),
                Tables\Columns\TextColumn::make('rank')
                    ->searchable(),
                Tables\Columns\TextColumn::make('short_rank')
                    ->searchable(),
                Tables\Columns\TextColumn::make('display_name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('commentaire')
                    ->searchable(),
                Tables\Columns\TextColumn::make('sub')
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\BulkAction::make('valider')
                        ->label("Valider les demandes de compte")
                        ->requiresConfirmation()
                        ->form([
                            Forms\Components\Toggle::make("make_them_admin")
                                ->label("En faire des administrateurs ?")
                                ->default(false),
                        ])
                        ->action(function ($records, $data)
                    {
                        ddd($data);
                    }),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMindefConnectUsers::route('/'),
            'create' => Pages\CreateMindefConnectUser::route('/create'),
            'edit' => Pages\EditMindefConnectUser::route('/{record}/edit'),
        ];
    }
}
