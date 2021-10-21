<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrucksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trucks', function (Blueprint $table) {
            $table->id();
            $table->string('type');
            $table->string('placas')->unique();
            $table->string('year')->nullable();
            $table->string('brand')->nullable();
            $table->string('color')->nullable();
            $table->string('gps_link')->nullable();
            $table->string('gps_user')->nullable();
            $table->string('gps_password')->nullable();
            $table->string('driver_card');
            $table->string('secure');
            $table->boolean('extinguidor');
            $table->boolean('alarma_reversa');
            $table->boolean('fumigacion');
            $table->boolean('driver_card_check');
            $table->boolean('secure_check');
            $table->boolean('calzas');

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
        Schema::dropIfExists('trucks');
    }
}
