<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMissingFacebookIdToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Check if the column doesn't exist before adding it.
        if (!Schema::hasColumn('users', 'facebook_id')) {
            Schema::table('users', function (Blueprint $table) {
                $table->string('facebook_id')->nullable()->unique();
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
        Schema::table('users', function (Blueprint $table) {
            // Check if the column exists before trying to drop it.
            if (Schema::hasColumn('users', 'facebook_id')) {
                $table->dropColumn('facebook_id');
            }
        });
    }
}
