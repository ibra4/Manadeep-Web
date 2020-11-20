<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('from');
            $table->string('fromName');
            $table->string('to');
            $table->string('toName');
            $table->decimal('cost');
            $table->bigInteger('driver_id')->unsigned()->nullable()->default(null);
            $table->bigInteger('user_id')->unsigned();
            $table->enum('status', ['canceled', 'in_propgress', 'driving', 'from_reached', 'finished', 'manadeep']);
            $table->enum('payer', ['sender', 'reciever']);
            $table->enum('package', ['electronic_devices', 'gifts', 'clothes', 'food', 'documents', 'heavy_weight']);
            $table->string('comments');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('driver_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
