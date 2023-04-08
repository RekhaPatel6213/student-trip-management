<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStaffAssignmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('works', function (Blueprint $table) {
            $table->smallIncrements('id');
            $table->string('name', 30);
            $table->enum('is_eagle_point',['YES','NO'])->default('NO');
            $table->enum('type',['STAFF'])->nullable();
            $table->enum('status', ['ACTIVE','INACTIVE'])->default('ACTIVE');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('staff_assignments', function (Blueprint $table) {
            $table->id();
            $table->date('trip_date');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedSmallInteger('work_id')->nullable();
            $table->json('notes')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('work_id')->references('id')->on('works')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('works');
        Schema::dropIfExists('staff_assignments');
    }
}
