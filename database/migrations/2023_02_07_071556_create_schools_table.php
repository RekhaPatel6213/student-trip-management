<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSchoolsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('schools', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50);
            $table->string('code', 10)->unique();
            $table->enum('type',['B','F','H','J','S'])->nullable()->comment('F = 5th | S = 6th | B = 5th&6th | H = High School | A = K-12 | J = Junior High');
            $table->unsignedSmallInteger('district_id')->nullable();
            $table->string('phone', 25)->nullable();
            $table->string('fax', 15)->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('district_id')->references('id')->on('districts')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('schools');
    }
}
