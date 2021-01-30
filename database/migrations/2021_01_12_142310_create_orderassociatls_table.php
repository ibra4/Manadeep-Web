<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderassociatlsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orderassociatls', function (Blueprint $table) {
            
            $table->id();
            $table->string('location'); 
            $table->string('city');
            $table->bigInteger('associate_id')->unsigned()->nullable()->default(null);
            $table->bigInteger('user_id')->unsigned();
            $table->enum('status', ['canceled', 'in_propgress', 'accept', 'finished']);
            $table->string('order_type');
            $table->string('comments');
            $table->timestamps();
            
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('associate_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orderassociatls');
    }
}
