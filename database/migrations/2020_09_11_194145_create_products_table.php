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
            $table->timestamps();
            $table->char('model_number',50);
            $table->unsignedBigInteger('category_name');
            $table->foreign('category_name')->references('id')->on('categories')->onDelete('cascade');
            $table->char('department_name',50);
            $table->char('manufacturer_name',50);
            $table->bigInteger('upc');
            $table->integer('sku');
            $table->decimal('regular_price',10,2);
            $table->decimal('sale_price',10,2);
            $table->mediumText('description');
            $table->mediumText('url');            
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
