<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @mixin IdeHelperClickEvent
 */
class ClickEvent extends Model
{
    use HasFactory;

    protected $casts = [
        'clicked_at' => 'datetime',
    ];

    public function affiliateCode(): BelongsTo
    {
        return $this->belongsTo(AffiliateCode::class);
    }
}
