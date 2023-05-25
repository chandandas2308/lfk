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
        Schema::create('multi_images', function (Blueprint $table) {
            $table->id();
            $table->string('owner_id')->nullable();
            $table->string('category')->nullable();
            $table->string('product_id')->nullable();
            $table->string('product')->nullable();
            $table->string('Image1')->nullable();
            $table->string('Image2')->nullable();
            $table->string('Image3')->nullable();
            $table->string('Image4')->nullable();
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
        Schema::dropIfExists('multi_images');
    }
};
