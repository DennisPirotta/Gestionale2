<?php

namespace App\Models;

use Database\Factories\StatusFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * App\Models\Status
 *
 * @property int $id
 * @property string $description
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection|Order[] $orders
 * @property-read int|null $orders_count
 * @method static StatusFactory factory(...$parameters)
 * @method static Builder|Status newModelQuery()
 * @method static Builder|Status newQuery()
 * @method static Builder|Status query()
 * @method static Builder|Status whereCreatedAt($value)
 * @method static Builder|Status whereDescription($value)
 * @method static Builder|Status whereId($value)
 * @method static Builder|Status whereUpdatedAt($value)
 * @mixin Eloquent
 */
class Status extends Model
{
    use HasFactory;

    protected $fillable = [
        'description'
    ];

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class, 'status_id');
    }
}
