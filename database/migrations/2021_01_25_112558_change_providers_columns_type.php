<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeProvidersColumnsType extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('providers', function (Blueprint $table) {
            $table->string('name')->unique()->change();
            $table->string('phone')->nullable()->change();
            $table->string('rfc')->unique()->change();
            $table->string('owner')->nullable()->change();
            $table->string('owner_phone')->nullable()->change();
            $table->string('coordinator')->nullable()->change();
            $table->string('coordinator_phone')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('providers', function (Blueprint $table) {
            $table->string('name')->change();
            $table->string('phone')->change();
            $table->string('rfc')->change();
            $table->string('owner')->change();
            $table->string('owner_phone')->change();
            $table->string('coordinator')->change();
            $table->string('coordinator_phone')->change();

            $table->dropUnique('providers_name_unique')->change();
            $table->dropUnique('providers_rfc_unique')->change();
        });
    }
}
