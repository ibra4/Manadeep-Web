<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rates', function (Blueprint $table) {
            $table->id();
            $table->enum('service', [1,2,3,4,5]);
            $table->enum('response', [1,2,3,4,5]);
            $table->enum('driver', [1,2,3,4,5]);
            $table->enum('quality', [1,2,3,4,5]);
            $table->enum('performance', [1,2,3,4,5]);
            $table->enum('app_style', [1,2,3,4,5]);
            $table->enum('price', [1,2,3,4,5]);
            $table->string('comments')->nullabe()->default(null);
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
        Schema::dropIfExists('rates');
    }
}
