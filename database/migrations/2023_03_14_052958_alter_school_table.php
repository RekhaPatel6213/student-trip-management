<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterSchoolTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('schools', function (Blueprint $table) {
            $table->after('district_id', function ($table) {
                $table->string('email',50)->nullable()->unique();
            });

            $table->after('fax', function ($table) {
                $table->enum('day_schedule_send', ['SEND','SEEN'])->nullable();
                $table->date('day_schedule_date')->nullable();
                $table->date('day_remind_schedule_date')->nullable();
                $table->enum('week_schedule_send', ['SEND','SEEN'])->nullable();
                $table->date('week_schedule_date')->nullable();
                $table->date('week_remind_schedule_date')->nullable();
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
        Schema::table('schools', function (Blueprint $table) {
            $table->dropColumn(['email', 'day_schedule_send', 'day_schedule_date', 'day_remind_schedule_date', 'week_schedule_send', 'week_schedule_date', 'week_remind_schedule_date']);
        });
    }
}
