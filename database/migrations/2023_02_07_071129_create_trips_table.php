<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTripsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trips', function (Blueprint $table) {
            $table->smallIncrements('id');
            $table->string('description');
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->enum('type', ['DAY','WEEK'])->comment('DAY = Day Trip | WEEK = Week Trip')->default('WEEK');
            $table->enum('week_day', ['1','3','4','5'])->comment('1 = 1 Day | 3 = 3 Day Week | 4 = 4 Day Week | 5 = 5 Day Week')->default('5');
            $table->enum('status', ['PENDING','ACTIVE','COMPLETED'])->default('PENDING');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('trips');
    }
}
