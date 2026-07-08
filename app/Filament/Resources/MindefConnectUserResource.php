<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MindefConnectUserResource\Pages;
use App\Filament\Resources\MindefConnectUserResource\Pages\ListMindefConnectUsers;
use App\Events\UnUtilisateurLocalDoitEtreCreeEvent;
use App\Events\UnUtilisateurLocalAEteCreeEvent;
use App\Mail\WelcomeMail;
use App\Models\MindefConnectUser;
use App\Models\Role;
use App\Models\User;
use App\Service\RandomPasswordGeneratorService;
use App\Service\AnnudefAjaxRequestService;
use Filament\Actions\BulkAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Arr;

class MindefConnectUserResource extends Resource
{
    protected static ?string $model = MindefConnectUser::class;

    protected static ?string $navigationLabel = 'Demandes Mindef Connect';

    protected static \BackedEnum|string|null $navigationIcon = 'heroicon-o-rectangle-stack';

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
            ])
        ;
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
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()
                        ->label('Refuser les demandes'),
                    BulkAction::make('valider')
                        ->label('Valider les demandes de compte')
                        ->color('success')
                        ->icon('heroicon-m-check')
                        ->requiresConfirmation()
                        ->form([
                            Select::make('roles')
                                ->label('Roles à attribuer')
                                ->multiple()
                                ->options(Role::where('guard_name', 'web')->get()->pluck('name', 'id')),
                            Toggle::make('make_them_admin')
                                ->label('En faire des administrateurs ?')
                                ->default(false),
                        ])
                        ->action(function ($records, $data) {
                            
                            foreach ($records as $record) {
                                if (null == User::where('email', $record->email)->first()) {
                                    $description = [
                                        'nom' => $record->nom,
                                        'prenom' => $record->prenom,
                                        'email' => $record->email,
                                        'unite' => $record->main_department_number
                                    ];

                                    $roles = collect($data['roles'])->map(function ($item) {
                                        return Role::find($item);
                                    });

                                    UnUtilisateurLocalDoitEtreCreeEvent::dispatch($description, []);
                                    
                                    $newUser = User::where("email", $record->email)->first();
                                    logger()->info("Utilisateur cree.", ["user" => $newUser]);

                                    $newUser->display_name = $record->display_name;
                                    $newUser->password = RandomPasswordGeneratorService::generateRandomString();
                                    $newUser->admin = $data['make_them_admin'] ? 1 : 0;
                                    $newUser->save();

                                    $newUser->syncRoles($roles);

                                    logger()->info("Roles attribues", ["user" => $newUser, "roles" => $roles]);

                                    $nid = AnnudefAjaxRequestService::searchUserNidByEmail($record->email);

                                    if ($nid != null && $nid !=='')
                                    {
                                        logger()->info("UnUtilisateurLocalAEteCreeEvent", ["user" => $newUser, "nid" => $nid]);
                                        $description["nid"] = $nid;
                                        $description["gradelong"] = $record->rank;
                                        UnUtilisateurLocalAEteCreeEvent::dispatch($description);
                                    }

                                    $record->delete();

                                    Mail::to($newUser->email)
                                        ->queue(new WelcomeMail($newUser))
                                    ;
                                }
                            }
                        }),
                ]),
            ])
        ;
    }

    public static function getRelations(): array
    {
        return [
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListMindefConnectUsers::route('/'),
            // 'create' => Pages\CreateMindefConnectUser::route('/create'),
            // 'edit' => Pages\EditMindefConnectUser::route('/{record}/edit'),
        ];
    }
}
