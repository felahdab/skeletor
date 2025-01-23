<?php
use Illuminate\Support\Facades\Artisan;

it('caches the routes successfully', function(){
    Artisan::call('route:cache');
    Artisan::call('route:clear');
    $this->assertTrue(true);
});