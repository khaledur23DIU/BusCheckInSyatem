<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCheckInPassengersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('check_in_passengers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('checkIn_id');
            $table->integer('student')->default(0);
            $table->integer('staff')->default(0);
            $table->integer('physically_disabled')->default(0);
            $table->integer('total')->default(0);
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('checkIn_id')->references('id')->on('check_ins')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('check_in_passengers');
    }
}
