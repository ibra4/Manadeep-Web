<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePricingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pricings', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('city_id_1')->unsigned();
            $table->bigInteger('city_id_2')->unsigned();
            $table->decimal('price');
            $table->timestamps();

            $table->foreign('city_id_1')->references('id')->on('cities')->onDelete('cascade');
            $table->foreign('city_id_2')->references('id')->on('cities')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pricings');
    }
}
