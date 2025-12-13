<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            // $table->string('phone')->nullable()->after('email');
            //$table->json('bio')->nullable()->after('role');
            //$table->string('image_path')->nullable()->after('bio');
            //$table->boolean('two_factor_enabled')->default(false)->after('disabled');
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['phone', 'bio', 'image_path']);
        });
    }
};
