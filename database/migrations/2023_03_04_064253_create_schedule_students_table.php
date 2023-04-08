<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateScheduleStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('schedule_students', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('schedule_id');
            $table->string('student_name', 50);
            $table->string('note')->nullable();
            $table->enum('free_meal', ['YES','NO'])->default('YES');
            $table->smallInteger('free_amount')->default(0);
            $table->enum('paid_meal', ['YES','NO'])->default('NO');
            $table->smallInteger('paid_amount')->default(0);
            $table->enum('reduced_meal', ['YES','NO'])->default('NO');
            $table->smallInteger('reduced_amount')->default(0);
            $table->timestamps();

            $table->foreign('schedule_id')->references('id')->on('schedules')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('schedule_students');
    }
}
