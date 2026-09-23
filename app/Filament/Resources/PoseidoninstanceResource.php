<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PoseidoninstanceResource\Pages\ListPoseidoninstances;
use App\Filament\Resources\PoseidoninstanceResource\Pages\ViewPoseidoninstance;
use App\Models\Poseidoninstance;
use Filament\Actions\ViewAction;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;

class PoseidoninstanceResource extends Resource
{
    protected static ?string $model = Poseidoninstance::class;

    protected static \BackedEnum|string|null $navigationIcon = 'heroicon-o-signal';

    protected static ?string $modelLabel = 'Instance Poseidon';
    protected static ?string $pluralModelLabel = 'Instances Poseidon';

    public static function infolist(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('uuid')
                    ->label('UUID'),
                TextEntry::make('nom'),
                TextEntry::make('last_seen')
                    ->label('Dernière vue')
                    ->formatStateUsing(fn (?int $state): ?string => $state !== null
                        ? Carbon::createFromTimestamp($state)->translatedFormat('d/m/Y H:i:s')
                        : null),
                TextEntry::make('data'),
                TextEntry::make('created_at')
                    ->dateTime(),
                TextEntry::make('updated_at')
                    ->dateTime(),
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
                IconColumn::make('active')
                    ->label('Actif')
                    ->boolean()
                    ->state(fn (Poseidoninstance $record): bool => $record->last_seen !== null
                        && $record->last_seen > Carbon::now()->subHours(48)->getTimestamp()),
                TextColumn::make('last_seen')
                    ->label('Dernière vue')
                    ->formatStateUsing(fn (?int $state): ?string => $state !== null
                        ? Carbon::createFromTimestamp($state)->translatedFormat('d/m/Y H:i:s')
                        : null)
                    ->sortable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([])
            ->recordActions([
                ViewAction::make(),
            ])
            ->toolbarActions([])
        ;
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function canEdit(Model $record): bool
    {
        return false;
    }

    public static function canDelete(Model $record): bool
    {
        return false;
    }

    public static function canDeleteAny(): bool
    {
        return false;
    }

    public static function getPages(): array
    {
        return [
            'index' => ListPoseidoninstances::route('/'),
            'view' => ViewPoseidoninstance::route('/{record}'),
        ];
    }
}
