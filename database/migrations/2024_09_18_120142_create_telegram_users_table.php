<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTelegramUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('telegram_users')) {
        Schema::create('telegram_users', function (Blueprint $table) {
            $table->id();
            $table->string('user_id');
            $table->string('username')->nullable();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('selected_language')->default('ru');
            $table->string('language_code')->nullable();
            $table->boolean('role')->nullable();
            $table->boolean('is_bot')->nullable();
            $table->string('status')->default('inactive');
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
        Schema::dropIfExists('telegram_users');
    }
}
