<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBookingOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('booking_orders', function (Blueprint $table) {
            $table->increments('id');
            $table->string('reservation_id');
            $table->string('client_id');
            $table->string('type');
            $table->string('firstname');
            $table->string('lastname');
            $table->string('email');
            $table->string('payment_type');
            $table->smallInteger('card')->unsigned();
            $table->string('billing_address');
            $table->string('product_name');
            $table->dateTime('check_in');
            $table->tinyInteger('length')->unsigned();
            $table->tinyInteger('adults')->unsigned();
            $table->tinyInteger('childs')->unsigned();
            $table->decimal('price', 8, 2);
            $table->decimal('extra_price', 8, 2);
            $table->decimal('total_price', 8, 2);
            $table->timestamps();

            $table->unique(['reservation_id', 'client_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('booking_orders');
    }
}
