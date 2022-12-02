<?php

namespace App\Models;

use Carbon\CarbonPeriod;
use Database\Factories\HourFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * App\Models\Hour
 *
 * @property int $id
 * @property int $count
 * @property string $date
 * @property string|null $description
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @method static HourFactory factory(...$parameters)
 * @method static Builder|Hour newModelQuery()
 * @method static Builder|Hour newQuery()
 * @method static Builder|Hour query()
 * @method static Builder|Hour whereCount($value)
 * @method static Builder|Hour whereCreatedAt($value)
 * @method static Builder|Hour whereDate($value)
 * @method static Builder|Hour whereDescription($value)
 * @method static Builder|Hour whereId($value)
 * @method static Builder|Hour whereUpdatedAt($value)
 * @mixin Eloquent
 *
 * @property int $hour_type_id
 * @property int $user_id
 * @property-read HourType $type
 * @property-read User $user
 *
 * @method static Builder|Hour filter(array $filters)
 * @method static Builder|Hour whereHourTypeId($value)
 * @method static Builder|Hour whereUserId($value)
 */
class Hour extends Model
{
    use HasFactory;

    protected $fillable = [
        'count', 'date', 'description', 'user_id', 'hour_type_id',
    ];

    public function scopeFilter($query, array $filters): void
    {
        if ($filters['month'] ?? false) {
            $period = CarbonPeriod::create(Carbon::parse(request('month'))->firstOfMonth(), Carbon::parse(request('month'))->lastOfMonth());
            $query->whereBetween('date', [$period->first(), $period->last()]);
        }
        if ($filters['user'] ?? false) {
            $query->where('user_id', request('user'));
        }
    }

    public function order_hour(): OrderHour
    {
        return OrderHour::where('hour_id', $this->id)->first();
    }

    public function type(): BelongsTo
    {
        return $this->belongsTo(HourType::class, 'hour_type_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function technical_report_hour(): TechnicalReportHour|null
    {
        return TechnicalReportHour::with('technical_report', 'hour')->where('hour_id', $this->id)->get()->first();
    }
}
