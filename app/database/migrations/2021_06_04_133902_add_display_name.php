<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDisplayName extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        //Modification table user
        Schema::table('user', function($table)
        {
            $table->string('display_name', 255);
            $table->dropColumn('firstname');
            $table->dropColumn('lastname');
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
        //Modification table user
        Schema::table('user', function($table)
        {
            $table->dropColumn('display_name');
            $table->string('firstname', 255);
            $table->string('lastname', 1);
        });
	}

}
