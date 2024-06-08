<?php

namespace Modules\Core\App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

abstract class BaseAuthModel extends Authenticatable
{
    use BaseModelTrait;
}
