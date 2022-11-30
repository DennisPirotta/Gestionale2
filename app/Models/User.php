<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Carbon\CarbonPeriod;
use Database\Factories\UserFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Notifications\DatabaseNotificationCollection;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\File;
use Laravel\Sanctum\HasApiTokens;
use Laravel\Sanctum\PersonalAccessToken;
use Spatie\ModelFlags\Models\Concerns\HasFlags;

/**
 * App\Models\User
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property Carbon|null $email_verified_at
 * @property string $password
 * @property string $language
 * @property string|null $remember_token
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property int $company_id
 * @property-read Company $company
 * @property-read DatabaseNotificationCollection|DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read Collection|Order[] $orders
 * @property-read int|null $orders_count
 * @property-read Collection|PersonalAccessToken[] $tokens
 * @property-read int|null $tokens_count
 * @method static UserFactory factory(...$parameters)
 * @method static Builder|User newModelQuery()
 * @method static Builder|User newQuery()
 * @method static Builder|User query()
 * @method static Builder|User whereCompanyId($value)
 * @method static Builder|User whereCreatedAt($value)
 * @method static Builder|User whereEmail($value)
 * @method static Builder|User whereEmailVerifiedAt($value)
 * @method static Builder|User whereId($value)
 * @method static Builder|User whereLanguage($value)
 * @method static Builder|User whereName($value)
 * @method static Builder|User wherePassword($value)
 * @method static Builder|User whereRememberToken($value)
 * @method static Builder|User whereUpdatedAt($value)
 * @mixin Eloquent
 * @property-read Collection|Hour[] $hours
 * @property-read int|null $hours_count
 * @property-read Collection|TechnicalReport[] $technical_reports
 * @property-read int|null $technical_reports_count
 * @property string|null $image
 * @property-read Collection|\Spatie\ModelFlags\Models\Flag[] $flags
 * @property-read int|null $flags_count
 * @property-read Collection|\App\Models\Location[] $locations
 * @property-read int|null $locations_count
 * @method static Builder|User flagged(string $name)
 * @method static Builder|User notFlagged(string $name)
 * @method static Builder|User whereImage($value)
 */
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasFlags;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'language',
        'image'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class, 'user_id');
    }

    public function hours(): HasMany
    {
        return $this->hasMany(Hour::class,'user_id');
    }

    public function technical_reports(): HasMany
    {
        return $this->hasMany(TechnicalReport::class,'user_id');
    }

    public function locations(): HasMany
    {
        return $this->hasMany(Location::class,'user_id');
    }

    public function hoursInPeriod(CarbonPeriod $period): Collection
    {
        return $this->hours->whereBetween('date',[$period->first(),$period->last()]);
    }

    public function clearImage(): void
    {
        if ($this->hasImage()) {
            $this->deleteImage();
        }
    }

    public function hasImage(): bool
    {
        return $this->image !== null && File::exists(public_path('storage/images/users/' . $this->image));
    }

    public function deleteImage(): void
    {
        File::delete(public_path('storage/images/users/' . $this->image));
    }
}
