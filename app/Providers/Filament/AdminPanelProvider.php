<?php

namespace App\Providers\Filament;

use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Facades\Filament;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Widgets;
use Filament\Navigation\MenuItem;
use Filament\Navigation\NavigationItem;
use Filament\FontProviders\SpatieGoogleFontProvider;
use Filament\Support\Colors\Color;

use Althinect\FilamentSpatieRolesPermissions\FilamentSpatieRolesPermissionsPlugin;

use App\Filament\AvatarProviders\SkeletorAvatarProvider;

use App\Http\Middleware\FilamentAuthenticate as FilamentAuthenticate;
use App\Http\Middleware\InitializeTenancyByPath;
use App\Http\Middleware\SetTenantCookieMiddleware;
use App\Http\Middleware\SetTenantDefaultForRoutesMiddleware;
use App\Http\Middleware\ReconfigureSessionDatabaseWhenTenantNotInitialized;

use App\Providers\Filament\Traits\UsesSkeletorPrefixAndMultitenancyTrait;

class AdminPanelProvider extends PanelProvider
{
    use UsesSkeletorPrefixAndMultitenancyTrait;

    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('Skeletor')
            ->path($this->prefix . '/admin')
            ->colors([
                'primary' => Color::Amber,
            ])
            ->profile()
            ->favicon(asset('assets/images/favicon-32x32.png'))
            ->font('Inter', provider: SpatieGoogleFontProvider::class)
            ->defaultAvatarProvider(SkeletorAvatarProvider::class)
            ->brandName("Administration")
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->plugin(FilamentSpatieRolesPermissionsPlugin::make())
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([
                //Widgets\AccountWidget::class,
                //Widgets\FilamentInfoWidget::class,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                InitializeTenancyByPath::class,
                ReconfigureSessionDatabaseWhenTenantNotInitialized::class,
                SetTenantDefaultForRoutesMiddleware::class,
                SetTenantCookieMiddleware::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                FilamentAuthenticate::class
            ])
            ->sidebarCollapsibleOnDesktop()
            ->userMenuItems([
                'help' => MenuItem::make()
                    ->label('Aide')
                    ->icon('heroicon-m-question-mark-circle')
                    ->url(fn () => url(config('skeletor.prefixe_instance') . '/docs/' . Filament::getCurrentPanel()->getId()) . '/', shouldOpenInNewTab:true),
                'apidoc' => MenuItem::make()
                    ->label('API')
                    ->icon('heroicon-m-cloud')
                    ->url(fn () => url(route('l5-swagger.default.api')), shouldOpenInNewTab:true),
            ]);
    }
}
