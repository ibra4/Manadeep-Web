<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateUsersTableTwo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('image')->nullable()->default(null);
            $table->string('email')->nullable()->default(null);
            $table->string('nationality')->nullable()->default(null);
            $table->string('qtr_id_no')->nullable()->default(null);
            $table->string('location')->nullable()->default(null);
            $table->string('locationName')->nullable()->default(null);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('image');
            $table->dropColumn('email');
            $table->dropColumn('nationality');
            $table->dropColumn('qtr_id_no');
            $table->dropColumn('location');
            $table->dropColumn('locationName');
        });
    }
}
