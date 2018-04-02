<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('histories', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('accounts_id')->unsigned();
            $table->integer('items_id')->unsigned();
            $table->integer('cart_id')->unsigned();
            $table->decimal('total')->nullable();
            $table->foreign('accounts_id')
                ->references('id')->on('users')
                ->onDelete('cascade');
            $table->foreign('items_id')
                ->references('id')->on('items')
                ->onDelete('cascade');
            $table->foreign('cart_id')
                ->references('id')->on('cart');
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
        Schema::dropIfExists('histories');
    }
}
