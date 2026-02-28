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
        Schema::table('guest_subscribers', function (Blueprint $table) {
            $table->string('unsubscribe_token', 64)
                  ->nullable()
                  ->unique()
                  ->after('verification_token');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('guest_subscribers', function (Blueprint $table) {
            // First drop the unique index (IMPORTANT for SQLite)
            $table->dropUnique('guest_subscribers_unsubscribe_token_unique');

            // Then drop the column
            $table->dropColumn('unsubscribe_token');
        });
    }
};