<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders.orders', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('customer_id');

            $table->bigInteger('sum')->nullable();
            $table->boolean('loyalty')->default(false);
            $table->enum('origin', ['store', 'website', 'app']);

            $table->string('country');
            $table->string('city');
            $table->string('street');
            $table->string('building');
            $table->string('postcode');

            $table->timestamp('delivered_at')->nullable();
            $table->timestamp('confirmed_at')->nullable();

            $table->timestamps();


            $table->foreign('customer_id')
                ->references('id')
                ->on('orders.customers')
                ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders.orders');
    }
}
