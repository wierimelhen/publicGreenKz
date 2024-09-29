<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class LogFromApp extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('log_app')) {
        Schema::table('log_app', function (Blueprint $table) {
            $table->id();
            $table->mediumText('data');
            $table->timestamps();
        });
    } }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('log_app', function (Blueprint $table) {
            //
        });
    }
}
