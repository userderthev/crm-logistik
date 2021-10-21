<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTowingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('towings', function (Blueprint $table) {
            $table->id();
            $table->string('plates')->unique();
            $table->string('type');
            $table->boolean('rails');
            $table->boolean('jacks');
            $table->boolean('oversize_permit');
            $table->boolean('without_filtration');
            $table->boolean('no_odor');
            $table->boolean('no_water_filtration');
            $table->string('traffic_card');
            $table->string('insurance_policy');

            $table->unsignedBigInteger('provider_id');
            $table->foreign('provider_id')->references('id')->on('providers');

            $table->unsignedBigInteger('status_id');
            $table->foreign('status_id')->references('id')->on('provider_statuses');

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
        Schema::dropIfExists('towings');
    }
}
