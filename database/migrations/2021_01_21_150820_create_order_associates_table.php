<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderAssociatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_associates', function (Blueprint $table) {
            $table->id();
            $table->string('location');
            $table->string('locationName');
            $table->bigInteger('associate_id')->unsigned()->nullable()->default(null);
            $table->bigInteger('user_id')->unsigned();
            $table->enum('status', ['canceled', 'in_progress', 'accept', 'finished']);
            $table->string('package_name');
            $table->string('SubPackage_name');
            $table->string('comments');
            
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('associate_id')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_associates');
    }
}
