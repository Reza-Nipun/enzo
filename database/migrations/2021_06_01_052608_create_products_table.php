<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->integer('category_id');
            $table->integer('sub_category_id');
            $table->string('product_name');
            $table->string('product_code')->nullable();
            $table->longText('product_short_description')->nullable();
            $table->float('price_in_bdt', 8, 2)->nullable();
            $table->float('price_in_usd', 8, 2)->nullable();
            $table->longText('meta_keywords')->nullable();
            $table->longText('meta_description')->nullable();
            $table->integer('status')->comment('(0=Inactive, 1=Active)');
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
        Schema::dropIfExists('products');
    }
}
