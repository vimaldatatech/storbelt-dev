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
            $table->foreignId('company_id')
                ->nullable()
                ->after('id')
                ->constrained('companies')
                ->nullOnDelete();

            // User status
            $table->enum('status', ['active', 'suspended'])->default('active')->after('password');

            // Useful for admin logs
            $table->timestamp('last_login_at')->nullable()->after('remember_token');

            // Soft delete (non-permanent delete)
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['company_id']);
            $table->dropColumn('company_id');

            $table->dropColumn('status');
            $table->dropColumn('last_login_at');

            $table->dropSoftDeletes();
        });
    }
};
