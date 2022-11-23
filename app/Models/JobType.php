<?php

namespace App\Models;

use Database\Factories\JobTypeFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * App\Models\JobType
 *
 * @property int $id
 * @property string $description
 * @property string $title
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection|Order[] $orders
 * @property-read int|null $orders_count
 * @method static JobTypeFactory factory(...$parameters)
 * @method static Builder|JobType newModelQuery()
 * @method static Builder|JobType newQuery()
 * @method static Builder|JobType query()
 * @method static Builder|JobType whereCreatedAt($value)
 * @method static Builder|JobType whereDescription($value)
 * @method static Builder|JobType whereId($value)
 * @method static Builder|JobType whereTitle($value)
 * @method static Builder|JobType whereUpdatedAt($value)
 * @mixin Eloquent
 * @property-read Collection|OrderHour[] $hours
 * @property-read int|null $hours_count
 */
class JobType extends Model
{
    use HasFactory;

    protected $fillable = [
        'description', 'title'
    ];

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class, 'job_type_id');
    }

    public function hours(): HasMany
    {
        return $this->hasMany(OrderHour::class, 'job_type_id');
    }
}
