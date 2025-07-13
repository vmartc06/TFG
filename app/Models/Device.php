<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Notifications\Notifiable;

/**
 * @method static create(array $array)
 * @method static where(string $string, string $string1)
 */
class Device extends Model
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'user_id',
        'enrollment_code',
        'api_key_encrypted'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function slots(): HasMany
    {
        return $this->hasMany(DeviceSlot::class);
    }

    public function info(): HasOne
    {
        return $this->hasOne(DeviceInfo::class);
    }

    // Custom methods

    public function isEnrolled(): bool
    {
        return ($this->enrollment_code == null) && ($this->info != null);
    }
}