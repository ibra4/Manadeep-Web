<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDriversTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('drivers', function (Blueprint $table) {
            $table->id();
            $table-> bigInteger('driver_id')->unsigned()->nullable()->default(null);
            $table-> bigInteger('Order_id')->unsigned()->nullable()->default(null);
            $table-> decimal('Order_Cost');
            $table->timestamps();
            
            $table->foreign('driver_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('Order_id')->references('id')->on('orders')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('drivers');
    }
}
