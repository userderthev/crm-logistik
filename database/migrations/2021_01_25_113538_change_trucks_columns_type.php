<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeTrucksColumnsType extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('trucks', function (Blueprint $table) {
            $table->string('placas')->unique()->change();
            $table->string('year')->nullable()->change();
            $table->string('brand')->nullable()->change();
            $table->string('color')->nullable()->change();
            $table->string('gps_link')->nullable()->change();
            $table->string('gps_user')->nullable()->change();
            $table->string('gps_password')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('trucks', function (Blueprint $table) {
            $table->string('placas')->change();
            $table->string('year')->change();
            $table->string('brand')->change();
            $table->string('color')->change();
            $table->string('gps_link')->change();
            $table->string('gps_user')->change();
            $table->string('gps_password')->change();

            $table->dropUnique('trucks_placas_unique')->change();
        });
    }
}
