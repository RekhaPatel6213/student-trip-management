<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTripInvitesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trip_invites', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('school_id');
            $table->string('invite_url')->nullable();
            $table->enum('type', ['WEEK','DAY'])->default('DAY');
            $table->enum('village_type', ['bear_creek','eagle_point'])->default('bear_creek');
            $table->enum('remind', ['YES','NO'])->default('NO');
            $table->date('remind_date')->nullable();
            $table->enum('status', ['SEND','SEEN','COMPLETED'])->default('SEND');
            $table->timestamps();

            $table->foreign('school_id')->references('id')->on('schools')->onUpdate('cascade')->onDelete('cascade');
        });

        Schema::table('schools', function (Blueprint $table) {
            $table->dropColumn(['day_schedule_send', 'day_schedule_date', 'day_remind_schedule_date', 'week_schedule_send', 'week_schedule_date', 'week_remind_schedule_date']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('trip_invites');
    }
}
