<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNews extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('news', function (Blueprint $table){
            $table->increments("id");
            $table->integer("uid")->comment("作者");
            $table->string("title")->comment("标题");
            $table->string("thumbs")->comment("导图");
            $table->text("content")->comment("内容");
            $table->integer("read")->comment("阅读量");
            $table->integer("newsrecommend")->comment("快报推荐ID");
            $table->integer('deleted')->nullable();
            $table->integer("created")->default(0);
            $table->integer("updated")->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('news');
    }
}
