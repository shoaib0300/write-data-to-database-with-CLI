<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('entity_id');
            $table->string('category_name');
            $table->string('sku');
            $table->string('name');
            $table->text('description');
            $table->text('short_desc');
            $table->float('price');
            $table->string('link');
            $table->string('image');
            $table->string('brand');
            $table->string('rating');
            $table->string('caffeine_type');
            $table->string('count');
            $table->string('flavored');
            $table->string('seasonal');
            $table->string('instock');
            $table->string('facebook');
            $table->string('isk_cup');
            $table->timestamps();
            $table->index('entity_id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('products');
    }
}
