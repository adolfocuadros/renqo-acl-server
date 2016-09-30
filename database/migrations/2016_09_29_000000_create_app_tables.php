<?php


use Illuminate\Database\Migrations\Migration;

class CreateAppTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		Schema::create('usuarios', function(\Moloquent\Schema\Blueprint $collection)
		{
			$collection->unique('usuario');
		});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
		Schema::drop('usuarios');
    }
}
