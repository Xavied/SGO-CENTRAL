<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFacsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('facs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('idEmpleado');
            $table->unsignedBigInteger('idCliente');
            $table->date('fct_fch');
            $table->timestamps();

            $table->foreign('idEmpleado')
            ->references('id')
            ->on('empleados')->onDelete('cascade');

            $table->foreign('idCliente')
            ->references('id')
            ->on('clientes')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('facs');
    }
}
