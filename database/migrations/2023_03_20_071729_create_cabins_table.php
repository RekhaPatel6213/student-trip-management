<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCabinsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cabins', function (Blueprint $table) {
            $table->smallIncrements('id');
            $table->string('name', 50)->unique();
            $table->string('code', 10)->unique();
            $table->smallInteger('eligible_student')->default(0);
            $table->enum('gender', ['Male','Female'])->default('Male');
            $table->enum('is_eagle_point',['YES','NO'])->default('NO');
            $table->json('block_week')->nullable();
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
        Schema::dropIfExists('cabins');
    }
}
