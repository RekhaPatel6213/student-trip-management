<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdministratorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('administrators', function (Blueprint $table) {
            $table->smallIncrements('id');
            $table->string('first_name', 30);
            $table->string('last_name', 30);
            $table->string('email',50)->nullable()->unique();
            $table->enum('title', ['A','AP','D','LT','P','S'])->comment('A = Administrator | AP = Assistant Principal | D = Director | LT = Lead Teacher | P = Principal | S = Superintendent');
            $table->enum('position', ['A','P','S'])->comment('A = Administrator | P = Principal | S = Superintendent');
            $table->unsignedSmallInteger('district_id');
            $table->unsignedBigInteger('school_id')->nullable();
            $table->string('school2', 50)->nullable();
            $table->string('phone', 25)->nullable();
            $table->string('fax', 15)->nullable();
            $table->string('address')->nullable();
            $table->unsignedSmallInteger('city_id');
            $table->unsignedSmallInteger('state_id');
            $table->string('zip', 10)->nullable();
            $table->text('comments')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('district_id')->references('id')->on('districts')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('school_id')->references('id')->on('schools')->onUpdate('cascade')->onDelete('cascade');

            $table->foreign('city_id')->references('id')->on('cities')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('state_id')->references('id')->on('states')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('administrators');
    }
}
