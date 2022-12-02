<?php

namespace App\Models;

use Database\Factories\CustomerFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\File;

/**
 * App\Models\Customer
 *
 * @property string $image
 * @property string $name
 * @property int $id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection|Order[] $orders
 * @property-read int|null $orders_count
 *
 * @method static CustomerFactory factory(...$parameters)
 * @method static Builder|Customer newModelQuery()
 * @method static Builder|Customer newQuery()
 * @method static Builder|Customer query()
 * @method static Builder|Customer whereCreatedAt($value)
 * @method static Builder|Customer whereId($value)
 * @method static Builder|Customer whereImage($value)
 * @method static Builder|Customer whereName($value)
 * @method static Builder|Customer whereUpdatedAt($value)
 * @mixin Eloquent
 *
 * @property-read Collection|TechnicalReport[] $technical_reports
 * @property-read int|null $technical_reports_count
 */
class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'image',
    ];

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class, 'customer_id');
    }

    public function technical_reports(): HasMany
    {
        return $this->hasMany(TechnicalReport::class, 'customer_id');
    }

    public function clearImage(): void
    {
        if ($this->hasImage()) {
            $this->deleteImage();
        }
    }

    public function hasImage(): bool
    {
        return $this->image !== null && File::exists(public_path('storage/images/customers/'.$this->image));
    }

    public function deleteImage(): void
    {
        File::delete(public_path('storage/images/customers/'.$this->image));
    }
}
