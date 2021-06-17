<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMensualkpisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mensualkpis', function (Blueprint $table) {

            $table->id();
            $table->string('formato');
            $table->unsignedInteger('local');
            $table->float('valor');
            $table->date('mes');
            
            $table->unsignedBigInteger('indicadorkpi_id');
            $table->foreign('indicadorkpi_id')->references('id')->on('indicadorkpis')->onDelete('cascade')->onUpdate('cascade');


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
        Schema::dropIfExists('mensualkpis');
    }
}
