<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateParksTable extends Migration
{
    public function up()
    {
        Schema::create('parks', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedBigInteger('city_id')->unsigned();
            $table->foreign('city_id')->references('id')->on('cities');
            $table->string('address');
            $table->text('description')->nullable();
            $table->double('latitude', 10, 7); // широта
            $table->double('longitude', 10, 7); // долгота
            $table -> string('availability', 55) -> nullable(true) -> default('enabled');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('parks');
    }
}
