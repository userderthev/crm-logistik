<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrafficTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('traffic', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('provider_id');
            $table->foreign('provider_id')->references('id')->on('providers');

            $table->unsignedBigInteger('truck_id');
            $table->foreign('truck_id')->references('id')->on('trucks');

            $table->unsignedBigInteger('operator_id');
            $table->foreign('operator_id')->references('id')->on('operators');

            $table->unsignedBigInteger('origin_city');
            $table->foreign('origin_city')->references('id')->on('cities');

            $table->unsignedBigInteger('target_city');
            $table->foreign('target_city')->references('id')->on('cities');

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
        Schema::dropIfExists('traffic');
    }
}
