<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
class CreateGuestSubscribersTable extends Migration
{
    public function up()
    {
        Schema::create('guest_subscribers', function (Blueprint $table) {
            $table->id();
            $table->string('email')->unique();
            $table->string('verification_token')->nullable();
            $table->string('unsubscribe_token')->nullable();
            $table->timestamp('verified_at')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('guest_subscribers');
    }
}