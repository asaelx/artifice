<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEstimateDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('estimate_details', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('quantity')->unsigned();
            $table->float('discount');
            $table->float('total');
            $table->boolean('show_dimensions')->default(false);
            $table->integer('product_id')->unsigned();
            $table->integer('estimate_id')->unsigned();
            $table->timestamps();

            $table->foreign('product_id')
                    ->references('id')
                    ->on('products');

            $table->foreign('estimate_id')
                    ->references('id')
                    ->on('estimates')
                    ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('estimate_details', function(Blueprint $table) {
            $table->dropForeign(['product_id']);
            $table->dropForeign(['estimate_id']);
        });

        Schema::drop('estimate_details');
    }
}
