<?php

namespace App\Models;

use Database\Factories\TechnicalReportFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * App\Models\TechnicalReport
 *
 * @property int $id
 * @property string $number
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property int $customer_id
 * @property int $user_id
 * @property int|null $secondary_customer_id
 * @property int|null $order_id
 * @property-read Customer $customer
 * @property-read Order|null $order
 * @property-read Customer|null $secondary_customer
 * @property-read User $user
 * @method static TechnicalReportFactory factory(...$parameters)
 * @method static Builder|TechnicalReport newModelQuery()
 * @method static Builder|TechnicalReport newQuery()
 * @method static Builder|TechnicalReport query()
 * @method static Builder|TechnicalReport whereCreatedAt($value)
 * @method static Builder|TechnicalReport whereCustomerId($value)
 * @method static Builder|TechnicalReport whereId($value)
 * @method static Builder|TechnicalReport whereNumber($value)
 * @method static Builder|TechnicalReport whereOrderId($value)
 * @method static Builder|TechnicalReport whereSecondaryCustomerId($value)
 * @method static Builder|TechnicalReport whereUpdatedAt($value)
 * @method static Builder|TechnicalReport whereUserId($value)
 * @mixin Eloquent
 */
class TechnicalReport extends Model
{
    use HasFactory;

    protected $fillable = [
        'number','customer_id','user_id','secondary_customer_id','order_id'
    ];

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class,'customer_id');
    }

    public function secondary_customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class,'secondary_customer_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class,'user_id');
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class,'order_id');
    }
}
