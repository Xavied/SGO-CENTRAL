<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePedidosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pedidos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('idEmpleado');
            $table->unsignedBigInteger('idMesa')->nullable();//borrar nullable si causa problemas
            $table->unsignedBigInteger('idEstado');
            $table->date('ped_fch');
            $table->boolean('ped_terminado')->default('false');
            $table->timestamps();

            $table->foreign('idEmpleado')
            ->references('id')
            ->on('empleados')->onDelete('cascade');

            $table->foreign('idMesa')
            ->references('id')
            ->on('mesas');


            $table->foreign('idEstado')
            ->references('id')
            ->on('estados');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pedidos');
    }
}
