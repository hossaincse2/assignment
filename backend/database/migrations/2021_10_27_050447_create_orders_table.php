<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->id();
            $table->string('order_no');
            $table->unsignedBigInteger('user_id');
            $table->float('total_amount');
            $table->integer('total_qty');
            $table->float('total_vat');
            $table->float('net_amount');
            $table->string('shipping_address');
            $table->string('contact_no');
            $table->string('shipping_method')->default('COD');
            $table->enum('status',['Approved', 'Rejected','Processing','Shipped','Delivered','Pending'])->default('Pending');
            $table->bigInteger('created_by');
            $table->bigInteger('updated_by')->unsigned()->nullable();
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
