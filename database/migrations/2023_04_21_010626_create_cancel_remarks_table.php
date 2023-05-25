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
        Schema::create('cancel_remarks', function (Blueprint $table) {
            $table->id();
            $table->integer('driver_table_id');
            $table->integer('driver_user_table_id');
            $table->string('consolidate_order_no');
            $table->longText('remark');
            $table->longText('cancel_image');
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
        Schema::dropIfExists('cancel_remarks');
    }
};
