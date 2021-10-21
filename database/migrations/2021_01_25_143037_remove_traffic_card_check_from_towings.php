<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveTrafficCardCheckFromTowings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('towings', function (Blueprint $table) {
            $table->dropColumn('traffic_card_check');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('towings', function (Blueprint $table) {
            $table->boolean('traffic_card_check');
        });
    }
}
