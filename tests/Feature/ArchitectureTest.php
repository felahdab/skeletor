<?php

arch()
    ->expect('App\Filament\AvatarProvider\AnnudefAvatarProvider')
    ->not
    ->toBeUsed();