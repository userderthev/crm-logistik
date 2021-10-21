<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRejectionMotiveIdToTraffic extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('traffic', function (Blueprint $table) {
            $table->unsignedBigInteger('rejection_motive_id')->nullable()->after('target_city');
            $table->foreign('rejection_motive_id')->references('id')->on('rejection_motives');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('traffic', function (Blueprint $table) {
            $table->dropForeign(['rejection_motive_id']);
            $table->dropColumn('rejection_motive_id');
        });
    }
}
