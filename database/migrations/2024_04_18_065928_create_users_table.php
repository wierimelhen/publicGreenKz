<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table -> engine = 'InnoDB';
            $table -> charset = 'utf8mb4';
            $table -> collation = 'utf8mb4_general_ci';
            $table->bigIncrements('id');

            $table->string('second_name', 30)->nullable(false);
            $table->string('name', 30)->nullable(true);
            $table->string('surname', 30)->nullable(true);
            $table->string('password', 100)->nullable(false);
            $table->string('remember_token', 100)->nullable(true);
            $table->string('phone', 30)->nullable(true);
            $table->integer('city_id')->nullable(true)->comment('City');
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
        Schema::dropIfExists('users');
    }
}
