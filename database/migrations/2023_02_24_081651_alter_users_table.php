<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->after('name', function ($table) {
                $table->string('first_name', 30);
                $table->string('last_name', 30);
                $table->unsignedSmallInteger('role_id')->nullable();
                $table->date('birth_date')->nullable();
                $table->string('phone', 15)->nullable();
                $table->string('fax', 15)->nullable();
            });

            $table->after('remember_token', function ($table) {
                $table->string('c_street')->nullable();
                $table->unsignedSmallInteger('c_state_id')->nullable();
                $table->unsignedSmallInteger('c_city_id')->nullable();
                $table->string('c_zip', 10)->nullable();
                $table->string('p_street')->nullable();
                $table->unsignedSmallInteger('p_state_id')->nullable();
                $table->unsignedSmallInteger('p_city_id')->nullable();
                $table->string('p_zip', 10)->nullable();
                $table->enum('status', ['ACTIVE','INACTIVE'])->default('ACTIVE');  
            });

            $table->after('updated_at', function ($table) {
                $table->softDeletes();
            });

            $table->foreign('role_id')->references('id')->on('roles')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'first_name', 'last_name', 'role_id', 'birth_date', 'phone', 'fax', 'c_street', 'c_state_id', 'c_city_id', 'c_zip', 'p_street', 'p_state_id', 'p_city_id', 'p_zip',  'status',
            ]);
        });
    }
}
