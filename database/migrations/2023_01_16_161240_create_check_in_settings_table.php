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
        Schema::create('check_in_settings', function (Blueprint $table) {
            $table->id();
            $table->integer('day1');
            $table->integer('day2');
            $table->integer('day3');
            $table->integer('day4');
            $table->integer('day5');
            $table->integer('day6');
            $table->integer('day7');
            $table->boolean('status')->default(true);
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
        Schema::dropIfExists('check_in_settings');
    }
};
