<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTicketPricingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ticket_pricings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('bus_route_id');
            $table->unsignedBigInteger('from_where');
            $table->unsignedBigInteger('to_where');
            $table->integer('price');
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('bus_route_id')->references('id')->on('bus_routes')->onDelete('cascade');
            $table->foreign('from_where')->references('id')->on('bus_stops')->onDelete('cascade');
            $table->foreign('to_where')->references('id')->on('bus_stops')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ticket_pricings');
    }
}
