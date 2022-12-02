<?php

namespace App\Models;

use Database\Factories\TechnicalReportHourFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * App\Models\TechnicalReportHour
 *
 * @property int $id
 * @property int $nightEU
 * @property int $nightXEU
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property int $hour_id
 * @property int $technical_report_id
 * @property-read Hour $hour
 * @property-read TechnicalReport $technical_report
 *
 * @method static TechnicalReportHourFactory factory(...$parameters)
 * @method static Builder|TechnicalReportHour newModelQuery()
 * @method static Builder|TechnicalReportHour newQuery()
 * @method static Builder|TechnicalReportHour query()
 * @method static Builder|TechnicalReportHour whereCreatedAt($value)
 * @method static Builder|TechnicalReportHour whereHourId($value)
 * @method static Builder|TechnicalReportHour whereId($value)
 * @method static Builder|TechnicalReportHour whereNightEU($value)
 * @method static Builder|TechnicalReportHour whereNightXEU($value)
 * @method static Builder|TechnicalReportHour whereTechnicalReportId($value)
 * @method static Builder|TechnicalReportHour whereUpdatedAt($value)
 * @mixin Eloquent
 */
class TechnicalReportHour extends Model
{
    use HasFactory;

    protected $fillable = [
        'nightEU', 'nightXEU', 'hour_id', 'technical_report_id',
    ];

    public function hour(): BelongsTo
    {
        return $this->belongsTo(Hour::class, 'hour_id');
    }

    public function technical_report(): BelongsTo
    {
        return $this->belongsTo(TechnicalReport::class, 'technical_report_id');
    }
}
