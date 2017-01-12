<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function(Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->string('slug');
            $table->text('description');
            $table->string('code');
            $table->string('stock');
            $table->string('regular_price');
            $table->string('sale_price');
            $table->integer('brand_id')->unsigned()->nullable();
            $table->integer('category_id')->unsigned();
            $table->timestamps();

            $table->foreign('brand_id')
                    ->references('id')
                    ->on('brands');

            $table->foreign('category_id')
                    ->references('id')
                    ->on('categories');
        });

        Schema::create('picture_product', function(Blueprint $table) {
            $table->integer('picture_id')->unsigned()->index();
                        $table->foreign('picture_id')
                                ->references('id')
                                ->on('pictures');

            $table->integer('product_id')->unsigned()->index();
                        $table->foreign('product_id')
                                ->references('id')
                                ->on('products');

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
        Schema::table('picture_product', function(Blueprint $table) {
            $table->dropForeign(['picture_id']);
            $table->dropForeign(['product_id']);
        });

        Schema::table('products', function(Blueprint $table) {
            $table->dropForeign(['brand_id']);
            $table->dropForeign(['category_id']);
        });

        Schema::drop('picture_product');
        Schema::drop('products');
    }
}
