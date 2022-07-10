<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRidesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rides', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('departure');
            $table->dateTime('departureTime');
            $table->string('destination');
            $table->integer('availableSeats');
            $table->decimal('price', 7, 2);
            $table->unsignedBigInteger('driverID');
            $table->foreign('driverID')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rides');
    }
}
