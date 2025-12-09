<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContentSectionsTable extends Migration
{
    public function up()
    {
        Schema::create('content_sections', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->json('content'); // { en: "", tl: "" }
            $table->integer('order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('content_sections');
    }
}
