<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSchedulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('schedules', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('school_id');
            $table->enum('type',['DAY','WEEK'])->default('DAY');
            $table->enum('days', ['1','2','3','4','5'])->comment('1 = 1 Day | 2 = 2 Day Week | 3 = 3 Day Week | 4 = 4 Day Week | 5 = 5 Day Week')->default('1');
            $table->enum('trip_number', ['1','2','3'])->comment('1 = 1 Trip | 2 = 2 Trip | 3 = 3 Trip')->default('1');
            $table->date('trip_date');
            $table->string('teacher', 50);
            $table->string('email', 50);
            $table->smallInteger('students')->default(0);
            $table->enum('status', ['PENDING','CONFIRMED','REGISTERED','CANCEL'])->default('PENDING');
            $table->enum('confirmation_send', ['YES','NO'])->default('NO');
            $table->dateTime('confirmation_send_date')->nullable();
            $table->enum('bill_send', ['YES','NO'])->default('NO');
            $table->dateTime('bill_send_date')->nullable();
            $table->enum('bill_status', ['SENT','SEEN','PAID'])->nullable();
            $table->enum('student_eligibility', ['STATE','SCHOOL','DIFFERENT'])->default('DIFFERENT');
            $table->enum('send_meal_request', ['YES','NO'])->default('NO');
            $table->smallInteger('free_amount')->default(0);
            $table->smallInteger('paid_amount')->default(0);
            $table->smallInteger('reduced_amount')->default(0);
            $table->string('meal_name', 50)->nullable();
            $table->string('meal_title')->nullable();
            $table->string('meal_email', 50)->nullable();
            $table->string('meal_signature')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('school_id')->references('id')->on('schools')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('schedules');
    }
}
