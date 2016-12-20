<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class BaseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('account')->unique();
            $table->string('name');
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('parking_lot', function (Blueprint $table) {
            $table->increments('id');
            $table->string('longitude');
            $table->string('latitude');
            $table->integer('quantity');
            $table->string('creator_id');
            $table->string('change_log_id');
            $table->timestamps();
        });

        Schema::create('change_log', function (Blueprint $table) {
            $table->increments('id');
            $table->string('parking_lot_id');
            $table->string('changer_id');
            $table->tinyInteger('status');
            $table->integer('quantity');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('users');
        Schema::drop('parking_lot');
        Schema::drop('change_log');
    }
}
