<?php

namespace App\Filament\Resources;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\TextColumn;
use Filament\Actions\EditAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\BulkAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use App\Filament\Resources\MindefConnectUserResource\Pages\ListMindefConnectUsers;
use App\Filament\Resources\MindefConnectUserResource\Pages;
use App\Filament\Resources\MindefConnectUserResource\RelationManagers;
use App\Models\MindefConnectUser;
use App\Models\User;
use App\Models\Role;
use App\Service\RandomPasswordGeneratorService;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

use Illuminate\Support\Facades\Mail;
use App\Mail\WelcomeMail;

class MindefConnectUserResource extends Resource
{
    protected static ?string $model = MindefConnectUser::class;

    protected static ?string $navigationLabel = "Demandes Mindef Connect";

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('email')
                    ->email()
                    ->required()
                    ->maxLength(255),
                TextInput::make('nom')
                    ->required()
                    ->maxLength(255)
                    ->default(''),
                TextInput::make('prenom')
                    ->required()
                    ->maxLength(255)
                    ->default(''),
                TextInput::make('main_department_number')
                    ->required()
                    ->maxLength(255)
                    ->default(''),
                TextInput::make('personal_title')
                    ->required()
                    ->maxLength(255)
                    ->default(''),
                TextInput::make('rank')
                    ->required()
                    ->maxLength(255)
                    ->default(''),
                TextInput::make('short_rank')
                    ->required()
                    ->maxLength(255)
                    ->default(''),
                TextInput::make('display_name')
                    ->required()
                    ->maxLength(255)
                    ->default(''),
                TextInput::make('commentaire')
                    ->maxLength(255)
                    ->default(null),
                TextInput::make('sub')
                    ->maxLength(255)
                    ->default(null),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('email')
                    ->searchable(),
                TextColumn::make('nom')
                    ->searchable(),
                TextColumn::make('prenom')
                    ->searchable(),
                TextColumn::make('main_department_number')
                    ->searchable(),
                TextColumn::make('personal_title')
                    ->searchable(),
                TextColumn::make('rank')
                    ->searchable(),
                TextColumn::make('short_rank')
                    ->searchable(),
                TextColumn::make('display_name')
                    ->searchable(),
                TextColumn::make('commentaire')
                    ->searchable(),
                TextColumn::make('sub')
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()
                        ->label("Refuser les demandes"),
                    BulkAction::make('valider')
                        ->label("Valider les demandes de compte")
                        ->color('success')
                        ->icon( 'heroicon-m-check')
                        ->requiresConfirmation()
                        ->form([
                            Select::make("roles")
                                ->label("Roles à attribuer")
                                ->multiple()
                                ->options(Role::where('guard_name', 'web')->get()->pluck('name', 'id')),
                            Toggle::make("make_them_admin")
                                ->label("En faire des administrateurs ?")
                                ->default(false),
                        ])
                        ->action(function ($records, $data)
                        {
                            //ddd($data);
                            foreach($records as $record){
                                if (User::where('email', $record->email)->first() == null){
                                    $attributes = [
                                        "nom" => $record->nom,
                                        "prenom" => $record->prenom,
                                        "email" => $record->email,
                                        "display_name" => $record->display_name,
                                        "password" => RandomPasswordGeneratorService::generateRandomString(),
                                        "admin" => $data['make_them_admin'] ? 1: 0,
                                    ];
                                    $newUser = User::create($attributes);

                                    $roles = collect($data['roles'])->map(function ($item)
                                    {
                                        return Role::find($item);
                                    });
                                    
                                    $newUser->refresh();
                                    $newUser->syncRoles($roles);

                                    $record->delete();

                                    Mail::to($newUser->email)
                                        ->queue(new WelcomeMail($newUser));

                                }
                            }
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
            'index' => ListMindefConnectUsers::route('/'),
            //'create' => Pages\CreateMindefConnectUser::route('/create'),
            //'edit' => Pages\EditMindefConnectUser::route('/{record}/edit'),
        ];
    }
}
