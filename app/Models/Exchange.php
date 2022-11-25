<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Models\Exchange
 *
 * @property int $id
 * @property string $datetime
 * @property string $exchange
 * @property float $value
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|Exchange newModelQuery()
 * @method static Builder|Exchange newQuery()
 * @method static Builder|Exchange query()
 * @method static Builder|Exchange whereCreatedAt($value)
 * @method static Builder|Exchange whereDatetime($value)
 * @method static Builder|Exchange whereExchange($value)
 * @method static Builder|Exchange whereId($value)
 * @method static Builder|Exchange whereUpdatedAt($value)
 * @method static Builder|Exchange whereValue($value)
 * @mixin Eloquent
 */
class Exchange extends Model
{
    use HasFactory;

    protected $fillable = [
        'symbol','value','datetime'
    ];
}
