<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookReceivedsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('book_receiveds', function (Blueprint $table) {
            $table->id();
            $table->integer('book_id');
            $table->string('book_name');
            $table->integer('quatity');
            $table->decimal('unit_price',18,0);
            $table->decimal('amount',18,0);
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
        Schema::dropIfExists('book_receiveds');
    }
}
