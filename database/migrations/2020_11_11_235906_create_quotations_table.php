<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuotationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quotations', function (Blueprint $table) {
            $table->id();
            $table->string('truck_type');
            $table->string('towing_type');
            $table->string('rate');
            $table->string('origin_city');
            $table->string('target_city');

            $table->boolean('epp_check');
            $table->boolean('imss_check');
            $table->boolean('client_app_check');
            $table->boolean('imss_payment_check');
            $table->boolean('insurance_check');
            $table->boolean('mirror_account_check');
            $table->boolean('reverse_alarm_check');
            $table->boolean('gps_check');
            $table->boolean('hydraulic_ramp_check');
            $table->boolean('no_odor_check');
            $table->boolean('wooden_floor_check');
            $table->boolean('no_spillage_check');
            $table->boolean('oversize_check');
            $table->boolean('hermetic_door_check');
            $table->boolean('no_filtration_check');
            $table->boolean('fumigation_check');

            $table->boolean('bands_check');
            $table->boolean('jacks_check');
            $table->boolean('chains_check');
            $table->boolean('rails_check');

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
        Schema::dropIfExists('quotations');
    }
}
