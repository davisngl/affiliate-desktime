<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @mixin IdeHelperAffiliateCode
 */
class AffiliateCode extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
    ];

    public function referrer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function clickEvents(): HasMany
    {
        return $this->hasMany(ClickEvent::class);
    }

    public function asCookiePayload(bool $encoded = false): array|string
    {
        $payload = [
            'referrer_id' => $this->user_id,
            'name'        => $this->referrer->name,
            'code'        => $this->code,
        ];

        return $encoded
            ? base64_encode(json_encode($payload))
            : $payload;
    }

    public function url(): string
    {
        return route('affiliate-code.show', ['affiliate' => $this->code]);
    }
}
