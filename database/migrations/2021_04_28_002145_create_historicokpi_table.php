<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHistoricokpiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('historicokpis', function (Blueprint $table) {
            $table->id();
            $table->string('formato');
            $table->unsignedInteger('local');
            $table->float('valor');
            $table->date('fecha');
            
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
        Schema::dropIfExists('historicokpi');
    }
}
