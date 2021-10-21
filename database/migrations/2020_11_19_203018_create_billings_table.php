<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBillingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('billings', function (Blueprint $table) {
            $table->id();
            $table->string('kind_person');
            $table->string('payment_way');
            $table->string('payment_method');
            $table->string('use_cfdi');
            $table->string('monthly_closure');
            $table->boolean('freight_retention_check');
            $table->boolean('discharge_retention_check');
            $table->boolean('maneuvers_retention_check');
            $table->boolean('distributions_retention_check');
            $table->string('evidence_reception');
            $table->string('evidence_reception_address');
            $table->string('delivery_days');
            $table->string('email');
            $table->string('site');
            $table->string('user');
            $table->string('password');

            $table->unsignedBigInteger('client_id');
            $table->foreign('client_id')->references('id')->on('clients');

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
        Schema::dropIfExists('billings');
    }
}
