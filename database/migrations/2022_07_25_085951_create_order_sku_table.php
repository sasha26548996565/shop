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
        Schema::create('order_sku', function (Blueprint $table) {
            $table->id();

            $table->foreignId('order_id')->constrained()->onDelete('CASCADE');
            $table->foreignId('sku_id')->constrained()->onDelete('CASCADE');
            $table->integer('count');
            $table->double('price');

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
        Schema::dropIfExists('order_sku');
    }
};
