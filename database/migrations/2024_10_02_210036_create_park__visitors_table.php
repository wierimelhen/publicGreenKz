<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateParkVisitorsTable extends Migration
{
    public function up()
    {
        Schema::create('park_visitors', function (Blueprint $table) {
            $table->id(); // Primary Key
            $table->unsignedBigInteger('park_id'); // Foreign Key для парка
            $table->timestamp('scan_time'); // Время сканирования QR-кода
            $table->string('visitor_ip')->nullable(); // IP-адрес посетителя (опционально)
            $table->timestamps(); // created_at и updated_at

            // Определение внешнего ключа
            $table->foreign('park_id')->references('id')->on('parks')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('park_visitors');
    }
}
