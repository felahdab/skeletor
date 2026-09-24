<?php

pest()->group('Skeletor');

arch()
    ->expect('App\Filament\AvatarProvider\AnnudefAvatarProvider')
    ->not
    ->toBeUsed()
;
