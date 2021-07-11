<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAreaInVillages extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('villages', 'area')) {
            Schema::table('villages', function (Blueprint $table) {
                $table->string('area')->after('amount_productive_age')->nullable();
            });
        }

        if (!Schema::hasColumn('villages', 'address_longitude')) {
            Schema::table('villages', function (Blueprint $table) {
                $table->string('address_longitude')->after('area')->nullable();
            });
        }

        if (!Schema::hasColumn('villages', 'address_latitude')) {
            Schema::table('villages', function (Blueprint $table) {
                $table->string('address_latitude')->after('address_longitude')->nullable();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasColumn('villages', 'area')) {
            Schema::table('villages', function (Blueprint $table) {
                $table->dropColumn('area');
            });
        }

        if (Schema::hasColumn('villages', 'address_longitude')) {
            Schema::table('villages', function (Blueprint $table) {
                $table->dropColumn('address_longitude');
            });
        }

        if (Schema::hasColumn('villages', 'address_latitude')) {
            Schema::table('villages', function (Blueprint $table) {
                $table->dropColumn('address_latitude');
            });
        }
    }
}
