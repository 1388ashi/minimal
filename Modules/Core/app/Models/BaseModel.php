<?php

namespace Modules\Core\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * Class BaseModel
 * @package Modules\Core\Entities
 * @method static create($attributes)
 * @method static findOrFail($id)
 * @method static find($id)
 * @method static Builder dateFilter()
 * @method static Builder sortFilter()
 * @method static Builder searchFilters()
 * @method static Builder filters()
 * @property mixed $name array  withCommonRelations()
 * @public static Type $var = null; @protected @static array  $commonRelations; // should be static
 */
abstract class BaseModel extends Model
{
    use BaseModelTrait;
}
