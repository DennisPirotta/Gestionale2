<?php

namespace App\Models;

use Database\Factories\OrderFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * App\Models\Order
 *
 * @property int $id
 * @property int $innerCode
 * @property string|null $outerCode
 * @property string $open
 * @property string|null $close
 * @property string|null $description
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property int $customer_id
 * @property int $user_id
 * @property int $created_by
 * @property int $company_id
 * @property int $country_id
 * @property int $status_id
 * @property int $job_type_id
 * @property-read Company $company
 * @property-read Country $country
 * @property-read User $creator
 * @property-read Customer $customer
 * @property-read JobType $job_type
 * @property-read Status $status
 * @property-read User $user
 * @method static OrderFactory factory(...$parameters)
 * @method static Builder|Order newModelQuery()
 * @method static Builder|Order newQuery()
 * @method static Builder|Order query()
 * @method static Builder|Order whereClose($value)
 * @method static Builder|Order whereCompanyId($value)
 * @method static Builder|Order whereCountryId($value)
 * @method static Builder|Order whereCreatedAt($value)
 * @method static Builder|Order whereCreatedBy($value)
 * @method static Builder|Order whereCustomerId($value)
 * @method static Builder|Order whereDescription($value)
 * @method static Builder|Order whereId($value)
 * @method static Builder|Order whereInnerCode($value)
 * @method static Builder|Order whereJobTypeId($value)
 * @method static Builder|Order whereOpen($value)
 * @method static Builder|Order whereOuterCode($value)
 * @method static Builder|Order whereStatusId($value)
 * @method static Builder|Order whereUpdatedAt($value)
 * @method static Builder|Order whereUserId($value)
 * @mixin Eloquent
 * @property-read Collection|OrderHour[] $hours
 * @property-read int|null $hours_count
 * @property-read Collection|TechnicalReport[] $technical_reports
 * @property-read int|null $technical_reports_count
 */
class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'innerCode', 'outerCode', 'open', 'close', 'description'
    ];

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class, 'country_id');
    }

    public function status(): BelongsTo
    {
        return $this->belongsTo(Status::class, 'status_id');
    }

    public function job_type(): BelongsTo
    {
        return $this->belongsTo(JobType::class, 'job_type_id');
    }

    public function hours(): HasMany
    {
        return $this->hasMany(OrderHour::class, 'order_id');
    }

    public function technical_reports(): HasMany
    {
        return $this->hasMany(TechnicalReport::class,'order_id');
    }
}
