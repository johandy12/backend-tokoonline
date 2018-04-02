<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('accounts_id')->unsigned();
            $table->foreign('accounts_id')
                ->references('id')->on('users')
                ->onDelete('cascade');
            $table->string('name');
            $table->integer('category_id')->unsigned();
            $table->foreign('category_id')
                ->references('id')->on('category')
                ->onDelete('cascade');
            $table->integer('stock');
            $table->decimal('price');
            $table->text('desc');
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
        Schema::dropIfExists('items');
    }
}
