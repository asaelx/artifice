<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEstimatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('estimates', function(Blueprint $table) {
            $table->increments('id');
            $table->string('folio');
            $table->enum('status', ['Pendiente', 'Aceptada', 'Rechazada'])->default('Pendiente');
            $table->date('expiration');
            $table->text('notes');
            $table->float('subtotal');
            $table->float('discount')->default('0');
            $table->float('save');
            $table->float('total');
            $table->integer('currency_id')->unsigned();
            $table->integer('client_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->timestamps();

            $table->foreign('currency_id')
                    ->references('id')
                    ->on('currencies');

            $table->foreign('client_id')
                    ->references('id')
                    ->on('clients');

            $table->foreign('user_id')
                    ->references('id')
                    ->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('estimates', function(Blueprint $table) {
            $table->dropForeign(['currency_id']);
            $table->dropForeign(['client_id']);
            $table->dropForeign(['user_id']);
        });

        Schema::drop('estimates');
    }
}
