<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBusStopsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bus_stops', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('serialize_id')->nullable();
            $table->unsignedBigInteger('bus_route_id');
            $table->string('bus_stop');
            $table->integer('bus_route_type');
            $table->string('bus_route_type_name');
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('bus_route_id')->references('id')->on('bus_routes')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bus_stops');
    }
}
