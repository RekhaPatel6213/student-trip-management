<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDistrictsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('districts', function (Blueprint $table) {
            $table->smallIncrements('id');
            $table->string('name', 50)->unique();
            $table->string('code', 10)->unique();
            $table->string('phone', 25)->nullable();
            $table->string('fax', 15)->nullable();
            $table->enum('investment',['YES','NO'])->default('NO')->comment('YES = 1 | NO = 0');
            $table->enum('in_county_budget_category',['YES','NO'])->default('NO')->comment('YES = 1 | NO = 0');
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
        Schema::dropIfExists('districts');
    }
}
