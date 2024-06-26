<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEcommerceSalesHeaderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ecommerce_sales_headers', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id');
            $table->string('order_number', 250);
            $table->text('response_code')->nullable();
            $table->string('order_source',250)->nullable();
            $table->string('customer_name',250);
            $table->string('customer_email',250);
            $table->string('customer_contact_number',250);
            $table->text('customer_address');
            $table->text('customer_delivery_adress');
            $table->string('customer_delivery_zip')->nullable();
            $table->string('delivery_tracking_number',250)->nullable();
            $table->string('delivery_courier',250)->nullable();
            $table->string('delivery_type',250);            
            $table->decimal('delivery_fee_amount',16,4)->default(0);
            $table->decimal('delivery_fee_discount',16,2)->nullable();
            $table->string('delivery_status',250)->default('Pending');
            $table->decimal('gross_amount',16,4)->default(0);
            $table->decimal('tax_amount',16,4)->default(0);
            $table->decimal('net_amount',16,4)->default(0);
            $table->decimal('discount_amount',16,4)->default(0);
            $table->decimal('ecredit_amount',16,4)->default(0);
            $table->string('payment_status',250)->default('UNPAID');            
            $table->string('status', 100)->default('active');
            $table->text('other_instruction')->nullable();
            $table->string('payment_method')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ecommerce_sales_headers');
    }
}
