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
        Schema::create('customer_facilities', function (Blueprint $table) {
            $table->id();
            $table->string('api_id')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->string('code')->nullable();
            $table->boolean('is_active')->default(true);
            $table->string('group')->nullable();
            $table->string('name')->nullable();
            $table->string('short_name')->nullable();
            $table->string('company_name')->nullable();
            $table->string('business_name')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->text('address')->nullable();
            $table->string('suburb')->nullable();
            $table->string('city')->nullable();
            $table->string('region')->nullable();
            $table->string('region_code')->nullable();
            $table->string('country_code')->nullable();
            $table->string('post_code')->nullable();
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            $table->json('trading_hours')->nullable();
            $table->json('facility_features')->nullable();
            $table->json('custom_fields')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->unique(['user_id', 'code']); // prevent duplicates for same user
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer_facilities');
    }
};
