<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Laravel\Sanctum\HasApiTokens;

/**
 * @mixin IdeHelperUser
 */
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
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
        'password'          => 'hashed',
    ];

    public function affiliateCodes(): HasMany
    {
        return $this->hasMany(AffiliateCode::class);
    }

    public function referrer(): HasOneThrough
    {
        return $this->hasOneThrough(
            User::class,
            AffiliateCode::class,
            'user_id',
            'referrer_id'
        );
    }

    public function createAffiliateUrl(): AffiliateCode
    {
        do {
            // Normally, code generation would be left to a mockable service,
            // where we could control how the code gets created and such (for tests).
            // But making it different through a factory is enough.
            $code = Str::random(10);
        } while (AffiliateCode::whereCode($code)->exists());

        return $this->affiliateCodes()->create([
            'code' => $code,
        ]);
    }
}
