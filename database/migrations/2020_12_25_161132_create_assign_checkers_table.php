<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssignCheckersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assign_checkers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('checker_id');
            $table->unsignedBigInteger('bus_stop_id');
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('checker_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('bus_stop_id')->references('id')->on('bus_stops')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('assign_checkers');
    }
}
