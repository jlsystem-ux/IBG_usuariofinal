<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePersonasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('personas', function (Blueprint $table) {
          $table->bigIncrements('id');
          $table->String('nombre',100);
          $table->String('tipo_documento',20)->nullable();
          $table->String('numero_documento',20)->nullable();
          $table->String('direccion',70)->nullable();
          $table->String('telefono',20)->nullable();
          $table->String('email',50)->nullable();
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
        Schema::dropIfExists('personas');
    }
}
