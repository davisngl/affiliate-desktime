<?php

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
        Schema::table('users', function (Blueprint $table) {
            /**
             * Normally, I would not reach for using foreign key constraints as cascading delete
             * might destroy data we did not anticipate... not even talking about annoying FK exceptions
             * that we may face when deleting data, therefore, in most cases, I would prefer
             * leaving it up for application control when it comes to deleting data, avoiding headache.
             *
             * But, as this is a tiny app, it's fine.
             */
            $table->string('affiliate_name')->nullable();
            $table->foreignIdFor(\App\Models\User::class, 'referrer_id')->nullable();
        });
    }
};
