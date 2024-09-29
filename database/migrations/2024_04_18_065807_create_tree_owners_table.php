<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTreeOwnersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tree_owners', function (Blueprint $table) {
            $table -> engine = 'InnoDB';
            $table -> charset = 'utf8mb4';
            $table -> collation = 'utf8mb4_general_ci';

            $table->bigIncrements('id');

            $table->string('ru', 155)->nullable(true);
            $table->string('kz', 155)->nullable(true);
            $table->string('en', 155)->nullable(true);

            $table -> string('availability', 55) -> nullable(true) -> default('enabled');

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
        Schema::dropIfExists('tree_owners');
    }
}
