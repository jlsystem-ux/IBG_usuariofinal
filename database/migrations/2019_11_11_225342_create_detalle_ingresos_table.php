<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDetalleIngresosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
     public function up()
     {
         Schema::create('detalle_ingresos', function (Blueprint $table) {
             $table->bigIncrements('id');
             $table->BigInteger('idingreso')->unsigned();
             $table->foreign('idingreso')->references('id')->on('ingresos')->onDelete('cascade');
             $table->BigInteger('idarticulo')->unsigned();
             $table->foreign('idarticulo')->references('id')->on('articulos');
             $table->BigInteger('cantidad');
             $table->decimal('precio', 11,2);

         });
     }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('detalle_ingresos');
    }
}
