<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProvidersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('providers', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('phone')->nullable();
            $table->string('rfc')->unique();
            $table->string('owner')->nullable();
            $table->string('owner_phone')->nullable();
            $table->string('coordinator')->nullable();
            $table->string('coordinator_phone')->nullable();
            $table->string('ine');
            $table->string('address');
            $table->string('owner_rfc');
            $table->string('letter');

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
        Schema::dropIfExists('providers');
    }
}
