<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetallesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detalles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('dtall_cant', 4);
            $table->double('dtall_valor', 8, 2);
            $table->unsignedBigInteger('idFac')->nullable();
            $table->unsignedBigInteger('idPlato');
            $table->unsignedBigInteger('idPedido');
            $table->timestamps();

            $table->foreign('idFac')
            ->references('id')
            ->on('facs')->onDelete('cascade');

            $table->foreign('idPlato')
            ->references('id')
            ->on('platos');

            $table->foreign('idPedido')
            ->references('id')
            ->on('pedidos')->onDelete('cascade');;
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('detalles');
    }
}
