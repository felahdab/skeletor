<?php

namespace Modules\Transformation\Dto;

use Spatie\LaravelData\Data;
use App\Models\User;

class ChangementLivretDeTransformationDto extends Data
{
    public function __construct(public User $modifying_user,
                                public User $modified_user,
                                public string $action,
                                public string $details
    )
    {}
}