<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->unsignedBigInteger('buyer_id')->nullable();
            $table->integer('amount')->default(0);
            $table->timestamps();
            $table->foreign('buyer_id')->references('id')->on('users');
        });

        Schema::create('order_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('order_id');
            $table->text('description')->nullable();
            $table->timestamps();
            $table->foreign('user_id')
                ->references('id')
                ->on('users');
            $table->foreign('order_id')
                ->references('id')
                ->on('orders');
        });

        Schema::create('order_detail_foods', function (Blueprint $table) {
            $table->unsignedBigInteger('order_detail_id');
            $table->unsignedBigInteger('food_id');
            $table->char('status', 15)->default(\App\Enums\OrderDetailStatus::NEW->value);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_detail_foods');
        Schema::dropIfExists('order_details');
        Schema::dropIfExists('orders');
    }
};
