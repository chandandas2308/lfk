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
        Schema::create('loyalty_points', function (Blueprint $table) {
            $table->id();
            $table->string('user_id');
            $table->integer('gained_points');
            $table->integer('spend_points')->nullable();
            $table->integer('remains_points')->nullable();
            $table->string('transaction_id');
            $table->string('transaction_amount');
            $table->string('wallet_id')->nullable();
            $table->dateTime('transaction_date')->nullable();
            $table->longText('log')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('loyalty_points');
    }
};
