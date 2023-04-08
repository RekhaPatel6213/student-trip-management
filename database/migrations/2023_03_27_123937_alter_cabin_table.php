<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterCabinTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cabins', function (Blueprint $table) {
            $table->after('is_eagle_point', function ($table) {
                $table->enum('is_disability',['YES','NO'])->default('NO');
            });
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cabins', function (Blueprint $table) {
            $table->dropColumn(['is_disability']);
        });
    }
}
