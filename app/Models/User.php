<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Contracts\AffiliateLinkGeneratorInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
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
        'referrer_id',
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

    public function createAffiliateUrl(): AffiliateCode
    {
        do {
            // Could also put it under a facade for the convenient 'fake' method that
            // it would supply for us in test, but this will do fine for mocking purposes.
            $code = app(AffiliateLinkGeneratorInterface::class)->generate();
        } while (AffiliateCode::whereCode($code)->exists());

        return $this->affiliateCodes()->create([
            'code' => $code,
        ]);
    }
}
