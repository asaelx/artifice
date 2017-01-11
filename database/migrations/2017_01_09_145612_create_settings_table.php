<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings', function(Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->string('owner');
            $table->string('email');
            $table->string('phone');
            $table->string('store_url');
            $table->string('address');
            $table->string('observations');
            $table->float('tax');
            $table->string('discount_code')->nullable();
            $table->integer('currency_id')->unsigned()->nullable();
            $table->integer('sidebar_logo_id')->unsigned()->nullable();
            $table->integer('estimate_logo_id')->unsigned()->nullable();
            $table->timestamps();

            $table->foreign('currency_id')
                    ->references('id')
                    ->on('currencies');

            $table->foreign('sidebar_logo_id')
                    ->references('id')
                    ->on('pictures');

            $table->foreign('estimate_logo_id')
                    ->references('id')
                    ->on('pictures');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('settings', function(Blueprint $table) {
            $table->dropForeign(['currency_id']);
            $table->dropForeign(['sidebar_logo_id']);
            $table->dropForeign(['estimate_logo_id']);
        });

        Schema::drop('settings');
    }
}
