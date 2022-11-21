<?php

namespace App\Models;

use Database\Factories\OrderHourFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;


/**
 * App\Models\OrderHour
 *
 * @property int $id
 * @property int $signed
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property int $order_id
 * @property int $hour_id
 * @property int $job_type_id
 * @property-read Hour $hour
 * @property-read JobType $job_type
 * @property-read Order $order
 * @method static OrderHourFactory factory(...$parameters)
 * @method static Builder|OrderHour newModelQuery()
 * @method static Builder|OrderHour newQuery()
 * @method static Builder|OrderHour query()
 * @method static Builder|OrderHour whereCreatedAt($value)
 * @method static Builder|OrderHour whereHourId($value)
 * @method static Builder|OrderHour whereId($value)
 * @method static Builder|OrderHour whereJobTypeId($value)
 * @method static Builder|OrderHour whereOrderId($value)
 * @method static Builder|OrderHour whereSigned($value)
 * @method static Builder|OrderHour whereUpdatedAt($value)
 * @mixin Eloquent
 */
class OrderHour extends Model
{
    use HasFactory;

    protected $fillable = [
        'signed', 'order_id', 'hour_id', 'job_type_id'
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    public function hour(): BelongsTo
    {
        return $this->belongsTo(Hour::class, 'hour_id');
    }

    public function job_type(): BelongsTo
    {
        return $this->belongsTo(JobType::class, 'job_type_id');
    }


}
