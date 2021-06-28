<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSocialAccountAndAboutInMembers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('members', 'about')) {
            Schema::table('members', function (Blueprint $table) {
                $table->string('about')->nullable();
            });
        }

        if (!Schema::hasColumn('members', 'social_fb')) {
            Schema::table('members', function (Blueprint $table) {
                $table->string('social_fb')->nullable();
            });
        }

        if (!Schema::hasColumn('members', 'social_ig')) {
            Schema::table('members', function (Blueprint $table) {
                $table->string('social_ig')->nullable();
            });
        }

        if (!Schema::hasColumn('members', 'social_twitter')) {
            Schema::table('members', function (Blueprint $table) {
                $table->string('social_twitter')->nullable();
            });
        }

        if (!Schema::hasColumn('members', 'social_youtube')) {
            Schema::table('members', function (Blueprint $table) {
                $table->string('social_youtube')->nullable();
            });
        }

        if (!Schema::hasColumn('members', 'social_twitch')) {
            Schema::table('members', function (Blueprint $table) {
                $table->string('social_twitch')->nullable();
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
        if (Schema::hasColumn('members', 'about')) {
            Schema::table('members', function (Blueprint $table) {
                $table->dropColumn('about');
            });
        }

        if (Schema::hasColumn('members', 'social_fb')) {
            Schema::table('members', function (Blueprint $table) {
                $table->dropColumn('social_fb');
            });
        }

        if (Schema::hasColumn('members', 'social_ig')) {
            Schema::table('members', function (Blueprint $table) {
                $table->dropColumn('social_ig');
            });
        }

        if (Schema::hasColumn('members', 'social_twitter')) {
            Schema::table('members', function (Blueprint $table) {
                $table->dropColumn('social_twitter');
            });
        }

        if (Schema::hasColumn('members', 'social_youtube')) {
            Schema::table('members', function (Blueprint $table) {
                $table->dropColumn('social_youtube');
            });
        }

        if (Schema::hasColumn('members', 'social_twitch')) {
            Schema::table('members', function (Blueprint $table) {
                $table->dropColumn('social_twitch');
            });
        }
    }
}
