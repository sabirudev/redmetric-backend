<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddVerifiedInMembers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('members', 'verified')) {
            Schema::table('members', function (Blueprint $table) {
                $table->boolean('verified')->default(0);
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
        if (Schema::hasColumn('members', 'verified')) {
            Schema::table('members', function (Blueprint $table) {
                $table->dropColumn('verified');
            });
        }
    }
}
