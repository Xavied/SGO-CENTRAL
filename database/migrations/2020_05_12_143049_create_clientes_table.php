<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('clientes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('cli_ci',10)->unique();
            $table->string('cli_nom', 255);
            $table->string('cli_dir', 255);
            $table->string('cli_email', 255)->nullable();//puede ser nulo
            $table->char('cli_telf', 15);
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
        Schema::dropIfExists('clientes');
    }
}
