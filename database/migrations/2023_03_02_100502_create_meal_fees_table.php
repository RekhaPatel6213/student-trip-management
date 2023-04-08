<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMealFeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('meal_fees', function (Blueprint $table) {
            $table->smallIncrements('id');
            $table->enum('type', ['STUDENT', 'TEACHER','COUNSELOR']);
            $table->enum('days', ['3','4','5'])->comment('3 = 3 Day Week | 4 = 4 Day Week | 5 = 5 Day Week');
            $table->decimal('price', 8, 2)->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('meal_fees');
    }
}
