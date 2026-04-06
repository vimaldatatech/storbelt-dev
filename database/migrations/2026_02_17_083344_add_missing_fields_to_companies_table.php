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
        Schema::table('companies', function (Blueprint $table) {
            $table->string('trading_name')->nullable()->after('name');
            $table->string('phone')->nullable()->after('trading_name');
            $table->text('ho_address')->nullable()->after('phone');
            $table->text('address')->nullable()->after('ho_address');
            $table->string('website_url')->nullable()->after('address');
            $table->string('abn_acn')->nullable()->after('website_url');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('companies', function (Blueprint $table) {
            $table->dropColumn([
                'trading_name',
                'phone',
                'ho_address',
                'address',
                'website_url',
                'abn_acn'
            ]);
        });
    }
};
