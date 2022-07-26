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
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();

            $table->string('code', 8);
            $table->double('value');
            $table->unsignedTinyInteger('type')->defualt(0);
            $table->foreignId('currency_id')->nullable()->constrained()->onDelete('cascade');
            $table->unsignedTinyInteger('only_ones')->default(0);
            $table->timestamp('expired_at');
            $table->text('description')->nullable();

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
        Schema::dropIfExists('coupons');
    }
};
