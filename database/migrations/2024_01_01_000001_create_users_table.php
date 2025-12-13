<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->enum('role', ['admin', 'librarian', 'staff'])->default('staff');
            $table->boolean('disabled')->default(false);
            $table->boolean('two_factor_enabled')->default(false)->after('disabled');
            $table->string('phone')->nullable();
            $table->string('image_path')->nullable();
            $table->json('bio')->nullable();
            $table->integer('order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->rememberToken();
            $table->timestamps();
            $table->timestamp('email_verified_at')->nullable()->after('two_factor_enabled');
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('users');
    }
};
