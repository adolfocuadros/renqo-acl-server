<?php

use Illuminate\Database\Schema\Blueprint;
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
		Schema::create('usuarios', function(Blueprint $table) {
			$table->engine = 'InnoDB';
		
			$table->increments('id');
			$table->string('nombre', 255)->nullable();
			$table->string('usuario', 45)->nullable();
			$table->string('pass', 128)->nullable();
			$table->integer('nivel')->nullable()->default(1);
			$table->text('permisos')->nullable();
			$table->integer('persona_id')->nullable();
		
		
			$table->timestamps();
		});

		Schema::create('sesiones', function(Blueprint $table) {
			$table->engine = 'InnoDB';
		
			$table->increments('id');
			$table->integer('usuarios_id')->unsigned();
			$table->string('token', 128)->nullable();
			$table->string('ip', 45)->nullable();
			$table->dateTime('expira')->nullable();
		
			$table->foreign('usuarios_id')
				->references('id')->on('usuarios');
		
			$table->timestamps();
		});

		Schema::create('permisos', function(Blueprint $table) {
			$table->engine = 'InnoDB';
		
			$table->integer('id');
			$table->string('codigo', 255)->nullable()->unique();
			$table->string('descripcion', 45)->nullable();
		
		
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
		Schema::drop('usuarios');
		Schema::drop('sesiones');
		Schema::drop('permisos');

    }
}
