<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUserRoomStats extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        //Modification table room
        Schema::table('room_user', function($table)
        {
            $table->integer('rank')->default(0);
            $table->integer('rankDayMinus1')->default(0);
            $table->integer('points')->default(0);
            $table->integer('pointsDayMinus1')->default(0);
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
        //Modification table room
        Schema::table('room_user', function($table)
        {
            $table->dropColumn('rank');
            $table->dropColumn('rankDayMinus1');
            $table->dropColumn('points');
            $table->dropColumn('pointsDayMinus1');
        });
	}

}
