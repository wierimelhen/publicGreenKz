<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTreesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trees', function (Blueprint $table) {
            $table -> engine = 'InnoDB';
            $table -> charset = 'utf8mb4';
            $table -> collation = 'utf8mb4_general_ci';

            $table->bigIncrements('id');

            $table->unsignedBigInteger('tree_species')->unsigned();
            $table->foreign('tree_species')->references('id')->on('species');

            $table->integer('height')->nullable(true)->comment('Ширина ствола в метрах');
            $table->integer('spread')->nullable(true)->comment('Величина кроны');
            $table->integer('trunk')->nullable(true)->comment('Ширина ствола в сантиметрах');
            $table->integer('age')->nullable(true);

            $table->unsignedBigInteger('vitality')->unsigned()->comment('Состояние');
            $table->foreign('vitality')->references('id')->on('tree_vitalities');

            $table->unsignedBigInteger('owner')->unsigned()->comment('В чьей собственности');
            $table->foreign('owner')->references('id')->on('tree_owners');

            $table->boolean('isCropped')->unsigned()->default(0)->comment('Постриженное ли');
            $table->boolean('isFelled')->unsigned()->default(0)->comment('Упало ли');
            $table->boolean('isDangerous')->unsigned()->default(0)->comment('Опасно ли');

            $table->double('longitude')->nullable(true)->comment('Долгота');
            $table->double('latitude')->nullable(true)->comment('Широта');

            $table->integer('city_id')->nullable(true)->comment('City');

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
        Schema::dropIfExists('trees');
    }
}
