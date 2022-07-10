<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRidesUsersPivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rides_users_pivot', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->unsignedBigInteger('rideID');
            $table->unsignedBigInteger('passengerID');
            $table->foreign('rideID')
                ->references('id')
                ->on('rides')
                ->onDelete('cascade');
            $table->foreign('passengerID')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rides_users_pivot');
    }
}
