<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIndicadorkpiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('indicadorkpis', function (Blueprint $table) {
            $table->id();
            $table->string('imagen')->nullable();
            $table->string('nombre', 40);
            $table->text('descripcion');
            $table->string('formato', 10);
            $table->string('descripcionsyb')->nullable();
            $table->unsignedInteger('umbral1');
            $table->unsignedInteger('umbral2');
            $table->unsignedInteger('umbral3');
            $table->unsignedInteger('umbral4');
            $table->unsignedInteger('horasmax');
            $table->unsignedInteger('diasmax');
            $table->unsignedInteger('mesesmax');
            $table->string('errorsindata')->nullable();
            $table->unsignedInteger('activo')->nullable();
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
        Schema::dropIfExists('indicadorkpi');
    }
}
