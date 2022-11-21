<?php

namespace App\Models;

use Database\Factories\HourTypeFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * App\Models\HourType
 *
 * @property int $id
 * @property string $description
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static HourTypeFactory factory(...$parameters)
 * @method static Builder|HourType newModelQuery()
 * @method static Builder|HourType newQuery()
 * @method static Builder|HourType query()
 * @method static Builder|HourType whereCreatedAt($value)
 * @method static Builder|HourType whereDescription($value)
 * @method static Builder|HourType whereId($value)
 * @method static Builder|HourType whereUpdatedAt($value)
 * @mixin Eloquent
 */
class HourType extends Model
{
    use HasFactory;

    protected $fillable = [
        'description'
    ];

    public function hours(): HasMany
    {
        return $this->hasMany(Hour::class,'hour_type_id');
    }
}
