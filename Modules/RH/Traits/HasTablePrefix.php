<?php

namespace Modules\RH\Traits;

use App\Traits\HasTablePrefix as BasePrefixTrait;

trait HasTablePrefix
{
    use BasePrefixTrait;

    protected $prefix = 'rh_';
}