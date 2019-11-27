<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
     public function up()
     {
         Schema::create('users', function (Blueprint $table) {
             $table->BigInteger('id')->unsigned();//llave foranea FK
             $table->foreign('id')->references('id')->on('personas')->onDelete('cascade'); //relacion users - persona
             $table->string('usuario')->unique();
             $table->string('password');
             $table->string('condicion')->default(1);

             $table->BigInteger('idrol')->unsigned();
             $table->foreign('idrol')->references('id')->on('roles');
             $table->rememberToken();

         //    $table->timestamp('email_verified_at')->nullable();
           //  $table->timestamps();


         });
     }

     /**
      * Reverse the migrations.
      *
      * @return void
      */
     public function down()
     {
         Schema::dropIfExists('users');
     }
   }
