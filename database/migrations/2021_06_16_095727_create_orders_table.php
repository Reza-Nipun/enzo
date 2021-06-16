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
            $table->string('invoice_no')->unique();
            $table->integer('customer_id');
            $table->float('total_amount')->nullable();
            $table->float('shipment_charge')->nullable();
            $table->float('vat_amount')->nullable();
            $table->float('net_amount')->nullable();
            $table->integer('payment_type')->comment('1=Cash on delivery, 2=e-Payment');
            $table->integer('payment_status')->comment('0=Pending, 1=Paid')->default(0);
            $table->integer('shipment_by')->comment('0=Enzo, 1=Pathao, 2=Redex')->nullable();
            $table->text('shipment_remarks')->nullable();
            $table->integer('status')->comment('0=Cancel, 1=Received, 2=Processing, 3=On Shipment, 4=Delivered');
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
