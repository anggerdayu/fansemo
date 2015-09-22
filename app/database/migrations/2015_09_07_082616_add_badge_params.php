<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddBadgeParams extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('badges', function(Blueprint $table)
		{
			$table->string('total_posts');
			$table->string('total_comments');
			$table->string('total_attacks');
			$table->string('total_assists');
			$table->string('total_defenses');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('badges', function(Blueprint $table)
		{
			$table->dropColumn('total_posts');
			$table->dropColumn('total_comments');
			$table->dropColumn('total_attacks');
			$table->dropColumn('total_assists');
			$table->dropColumn('total_defenses');
		});
	}

}
