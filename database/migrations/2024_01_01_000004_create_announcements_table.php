<?php

// ====================
// DATABASE MIGRATIONS
// ====================

// database/migrations/2024_01_01_000001_create_users_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
class CreateAnnouncementsTable extends Migration
{
    public function up()
    {
        Schema::create('announcements', function (Blueprint $table) {
            $table->id();
            $table->json('title'); // Multilingual
            $table->json('content'); // Multilingual
            $table->string('image_path')->nullable();
            $table->enum('priority', ['low', 'medium', 'high'])->default('medium');
            $table->timestamp('published_at')->nullable();
            $table->timestamp('expires_at')->nullable();
            $table->boolean('is_active')->default(true);
            $table->foreignId('created_by')->constrained('users');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('announcements');
    }
}