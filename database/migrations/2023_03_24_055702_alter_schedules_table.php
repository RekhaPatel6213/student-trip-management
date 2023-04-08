<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
//use DB;

class AlterSchedulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('schedules', function (Blueprint $table) {
            $table->after('status', function ($table) {
                $table->enum('is_eagle_point',['YES','NO'])->default('NO');  
            });

            $table->after('meal_email', function ($table) {
                $table->string('meal_phone', 15)->nullable();  
            });

            \DB::statement("ALTER TABLE `schedules` CHANGE `status` `status` ENUM('PENDING','CONFIRMED','REGISTERED','FINALIZED','CANCEL') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'PENDING';");
        });

        Schema::table('schools', function (Blueprint $table) {
            $table->after('week_remind_schedule_date', function ($table) {
                $table->enum('is_eagle_point',['YES','NO'])->default('NO');  
            });
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('schedules', function (Blueprint $table) {
            $table->dropColumn(['is_eagle_point', 'meal_phone']);
        });

        Schema::table('schools', function (Blueprint $table) {
            $table->dropColumn(['is_eagle_point']);
        });
    }
}
