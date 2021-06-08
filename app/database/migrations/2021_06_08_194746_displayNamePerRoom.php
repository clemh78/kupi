<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DisplayNamePerRoom extends Migration {

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
            $table->increments('id')->unsigned()->first();
            $table->string('display_name', 255)->nullable();
        });

        //Copy column from last table to new table
        foreach(RoomUser::all() as $item)
        {
            $user = DB::table('user')->where('id', $item->user_id)->get();
            $item->display_name = $user[0]->display_name;
            $item->save();
        }

        //Modification table user
        Schema::table('user', function($table)
        {
            $table->dropColumn('display_name');
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
            $table->dropColumn('id');
            $table->dropColumn('display_name');
        });

        //Modification table user
        Schema::table('user', function($table)
        {
            $table->string('display_name', 255)->default("ROLLBACK");
        });
	}

}
