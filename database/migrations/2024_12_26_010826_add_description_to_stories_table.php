<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('stories', function (Blueprint $table) {
            $table->string('description')->nullable()->after('duration');
        });
    }

    /**
     * Reverse the migrations.
     */

    public function down()
    {
        Schema::table('stories', function (Blueprint $table) {
            $table->dropColumn('description');
        });
    }
};
