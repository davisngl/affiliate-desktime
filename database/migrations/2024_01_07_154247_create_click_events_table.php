<?php

use App\Models\AffiliateCode;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('click_events', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(AffiliateCode::class)
                ->constrained()
                ->cascadeOnDelete();
            $table->timestamp('clicked_at')->useCurrent();
            $table->timestamps();
        });
    }
};
