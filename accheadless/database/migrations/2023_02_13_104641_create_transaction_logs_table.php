<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();
        Schema::create('transaction_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->foreignId('operator_id')->constrained()->nullable();
            $table->foreignId('provience_id')->constrained()->nullable();
            $table->foreignId('device_id')->constrained()->nullable();
            $table->foreignId('operating_system_id')->constrained()->nullable();
            $table->foreignId('browser_id')->constrained()->nullable();
            $table->foreignId('transaction_id')->constrained();
            $table->timestamps();
        });
        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transaction_logs');
    }
};
