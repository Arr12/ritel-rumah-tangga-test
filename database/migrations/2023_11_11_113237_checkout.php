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
        Schema::create('checkout', function (Blueprint $table) {
            $table->id();
            $table->string('invoice');
            $table->string('payment_methods');
            $table->integer('promo_code')->default(0);
            $table->string('comment');
            $table->string('shipping_address_id');
            $table->string('billing_address_id');
            $table->string('shipping');
            $table->double('tax', 15, 8);
            $table->double('discount', 15, 8);
            $table->double('total', 15, 8);
            $table->integer('remove')->nullable()->default(0);
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
        Schema::dropIfExists('checkout');
    }
};
