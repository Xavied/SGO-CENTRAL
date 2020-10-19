<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlatosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('platos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('plt_nom', 255)->unique();
            $table->string('plt_des', 255);
            $table->string('plt_tipo', 255);
            $table->double('plt_pvp', 8, 2);
            $table->boolean('plt_visbl')->default('true');
            $table->boolean('plt_iva')->default('false');
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
        Schema::dropIfExists('platos');
    }
}
