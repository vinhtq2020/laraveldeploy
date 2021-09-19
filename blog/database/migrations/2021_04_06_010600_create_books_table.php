<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->string('book_name');
            // $table->string('book_image');
            $table->string('book_seo');
            $table->integer('category_id');
            $table->text('content')->nullable();
            $table->integer('nxb_id')->nullable();
            $table->integer('author_id');
            $table->integer('republic')->nullable();
            $table->integer('year')->nullable();
            $table->decimal('price');
            $table->integer('quatity')->default(0);
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
        Schema::dropIfExists('books');
    }
}
