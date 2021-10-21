<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAvailableUnitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('available_units', function (Blueprint $table) {
            $table->id();
            $table->string('slug');
            $table->dateTime('deadline');

            $table->unsignedBigInteger('traffic_id');
            $table->foreign('traffic_id')->references('id')->on('traffic');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('available_units');
    }
}
