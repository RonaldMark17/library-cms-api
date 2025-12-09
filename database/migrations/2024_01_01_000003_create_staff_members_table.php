<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
class CreateStaffMembersTable extends Migration
{
    public function up()
    {
        Schema::create('staff_members', function (Blueprint $table) {
            $table->id();
            $table->json('name'); // Multilingual
            $table->json('role'); // Multilingual
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('image_path')->nullable();
            $table->json('bio')->nullable(); // Multilingual
            $table->integer('order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('staff_members');
    }
}