<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContractorsTable extends Migration
{
    public function up()
    {
        Schema::create('contractors', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table -> string('availability', 55) -> nullable(true) -> default('enabled');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('contractors');
    }
}
