<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RemotesystemResource\Pages\CreateRemotesystem;
use App\Filament\Resources\RemotesystemResource\Pages\EditRemotesystem;
use App\Filament\Resources\RemotesystemResource\Pages\ListRemotesystems;
use App\Filament\Resources\RemotesystemResource\RelationManagers\TokensRelationManager;
use App\Models\Remotesystem;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class RemotesystemResource extends Resource
{
    protected static ?string $model = Remotesystem::class;

    protected static \BackedEnum|string|null $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $modelLabel = 'Système distant';
    protected static ?string $pluralModelLabel = 'Systèmes distants';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nom')
                    ->required()
                    ->maxLength(255),
            ])
        ;
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('uuid')
                    ->label('UUID')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('nom')
                    ->searchable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
        ;
    }

    public static function getRelations(): array
    {
        return [
            TokensRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListRemotesystems::route('/'),
            'create' => CreateRemotesystem::route('/create'),
            'edit' => EditRemotesystem::route('/{record}/edit'),
        ];
    }
}
