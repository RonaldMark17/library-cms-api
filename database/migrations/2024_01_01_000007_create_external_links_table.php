<?php

// ====================
// DATABASE MIGRATIONS
// ====================

// database/migrations/2024_01_01_000001_create_users_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
class CreateExternalLinksTable extends Migration
{
    public function up()
    {
        Schema::create('external_links', function (Blueprint $table) {
            $table->id();
            $table->json('title'); // Multilingual
            $table->string('url');
            $table->json('description')->nullable(); // Multilingual
            $table->string('icon')->nullable();
            $table->integer('order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('external_links');
    }
}