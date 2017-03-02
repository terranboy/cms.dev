<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('post_translations', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('post_id')->unsigned();
            $table->string('title');
            $table->text('excerpt');
            $table->text('content');
            $table->string('seo_title');
            $table->text('seo_description');
            $table->text('seo_keywords');
            $table->string('locale')->index();

            $table->unique(['post_id','locale']);
            $table->foreign('post_id')->references('id')->on('posts')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('post_translations');
    }
}
