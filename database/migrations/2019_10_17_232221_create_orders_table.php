<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
			$table->text('note')->nullable();
            $table->text('address');
            $table->integer('offercode')->nullable()->unique();
            $table->decimal('cost')->default(0.00);
            $table->decimal('commission')->nullable();;
			$table->decimal('delivery_cost')->default(0.00);
            $table->decimal('total')->default(0.00);
            $table->decimal('net')->nullable();
			$table->datetime('need_delivery_at');
			$table->integer('delivery_time_id');
            $table->integer('shop_id');          // first relation
            $table->integer('client_id');
            $table->datetime('delivered_at')->nullable();
            $table->enum('state', array('pending', 'accepted', 'rejected'));
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
        Schema::dropIfExists('orders');
    }
}
