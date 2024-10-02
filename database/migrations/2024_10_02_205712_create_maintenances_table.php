<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMaintenancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('maintenances', function (Blueprint $table) {
            $table->id(); // Primary Key
            $table->unsignedBigInteger('park_id'); // Foreign Key для парка
            $table->unsignedBigInteger('contractor_id'); // Foreign Key для подрядчика
            $table->string('maintenance_type'); // Тип обслуживания (обрезка, полив и т.д.)
            $table->date('date_performed'); // Дата выполнения обслуживания
            $table->text('notes')->nullable(); // Дополнительные заметки
            $table->timestamps(); // created_at и updated_at

            // Определение внешних ключей
            $table->foreign('park_id')->references('id')->on('parks');
            $table->foreign('contractor_id')->references('id')->on('contractors');
        
            $table -> string('availability', 55) -> nullable(true) -> default('enabled');
        });
    }

    public function down()
    {
        Schema::dropIfExists('maintenances');
    }
}
