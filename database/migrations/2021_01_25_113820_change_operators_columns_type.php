<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeOperatorsColumnsType extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('operators', function (Blueprint $table) {
            $table->string('name')->unique()->change();
            $table->string('phone')->nullable()->change();
            $table->string('home_phone')->nullable()->change();
            $table->string('address')->nullable()->change();
            $table->unsignedBigInteger('city_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('operators', function (Blueprint $table) {
            $table->string('name')->change();
            $table->string('phone')->change();
            $table->string('home_phone')->change();
            $table->string('address')->change();
            $table->unsignedBigInteger('city_id')->change();

            $table->dropUnique('operators_name_unique')->change();
        });
    }
}
