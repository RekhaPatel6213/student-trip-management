<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterScheduleStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('schedule_students', function (Blueprint $table) {
            $table->after('student_name', function ($table) {
                $table->string('first_name', 30)->nullable();
                $table->string('last_name', 30)->nullable();
                $table->enum('gender', ['MALE','FEMALE'])->default('MALE');
                $table->string('teacher_cabin_id', 3)->nullable();
                $table->unsignedSmallInteger('cabin_id')->nullable();
                $table->enum('is_eagle_point',['YES','NO'])->default('NO');
                $table->enum('is_disability',['YES','NO'])->default('NO');
            });

            $table->after('updated_at', function ($table) {
                $table->softDeletes();
            });

            $table->foreign('cabin_id')->references('id')->on('cabins')->onUpdate('cascade')->onDelete('cascade'); 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('schedule_students', function (Blueprint $table) {
            $table->dropColumn([
                'first_name', 'last_name', 'gender', 'cabin_id', 'is_eagle_point', 'is_disability',
            ]);
        });
    }
}
