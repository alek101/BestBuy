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
            $table->char('model',50);
            $table->char('type',50);
            $table->unsignedBigInteger('category');
            $table->foreign('category')->references('id')->on('categories')->onDelete('cascade');
            $table->char('manufacturor',50);
            $table->integer('serial');
            $table->integer('sku');
            $table->decimal('prise',10,2);
            $table->decimal('discount',10,2);
            $table->mediumText('description');
            $table->mediumText('link');            
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
