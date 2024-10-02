<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQrCodesTable extends Migration
{
    public function up()
    {
        Schema::create('qr_codes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('park_id')->unsigned();
            $table->foreign('park_id')->references('id')->on('parks');
            $table->string('code');
            $table -> string('availability', 55) -> nullable(true) -> default('enabled');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('qr_codes');
    }
}
