<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBookCategorieTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('book_categorie', function (Blueprint $table) {
            $table->integer('book_id')->unsigned()->index();
            $table->foreign('book_id')->references('id')->on('books')->onDelete('cascade');

            $table->integer('categorie_id')->unsignet();
            $table->foreign('categorie_id')->references('id')->on('categories')->onDelete('cascade');

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
        Schema::drop('book_categorie');
    }
}
