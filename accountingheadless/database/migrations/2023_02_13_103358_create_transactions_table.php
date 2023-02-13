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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->unsignedBigInteger('transactionLog_id');
            $table->foreign('transactionLog_id')->references('id')->on('transaction_logs');
            $table->string('card_number')->nullable();
            $table->enum('status', ['success', 'pending', 'failed']);
            $table->string('origin_account')->nullable();
            $table->string('destination_account')->nullable();
            $table->string('amount')->nullable();
            $table->foreignId('gateway_id')->constrained()->nullable();
            $table->enum('transaction_type', ['deposit', 'withdraw']);
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
        Schema::dropIfExists('transactions');
    }
};
