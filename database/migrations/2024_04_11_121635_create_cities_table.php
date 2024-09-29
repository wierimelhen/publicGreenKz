<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cities', function (Blueprint $table) {
                $table -> engine = 'InnoDB';
                $table -> charset = 'utf8mb4';
                $table -> collation = 'utf8mb4_general_ci';
                $table->bigIncrements('id');
                $table->string('city', 30)->nullable(false);
                $table->string('domain', 50)->nullable(false);
                $table -> string('availability', 55) -> nullable(false) -> default('enabled');

                $table -> timestamps();
            });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cities');
    }
}
