<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateParkContractorsTable extends Migration
{
    public function up()
    {
        Schema::create('park_contractors', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('park_id');
            $table->unsignedBigInteger('contractor_id');
            $table->foreign('park_id')->references('id')->on('parks');
            $table->foreign('contractor_id')->references('id')->on('contractors');
            $table -> string('availability', 55) -> nullable(true) -> default('enabled');
            $table->text('responsibilities')->nullable(); // обязанности подрядчика в парке
            $table->date('start_date')-> nullable(true);
            $table->date('end_date')-> nullable(true);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('park_contractors');
    }
}
