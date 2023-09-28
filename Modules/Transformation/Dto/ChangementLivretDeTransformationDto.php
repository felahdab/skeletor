<?php

namespace Modules\Transformation\Dto;

use Spatie\LaravelData\Data;
use App\Models\User as AppUser;
use Modules\Transformation\Entities\User;

class ChangementLivretDeTransformationDto extends Data
{
    public function __construct(public AppUser $modifying_user,
                                public User $modified_user,
                                public string $action,
                                public string $details
    )
    {}
}