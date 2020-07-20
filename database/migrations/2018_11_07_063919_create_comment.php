<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateComment extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comment', function (Blueprint $table){
            $table->increments("id")->comment("主键ID");
            $table->integer("uid")->comment("评论者ID");
            $table->string('app')->comment("评论项目");
            $table->integer('app_id')->comment("评论项目ID");
            $table->integer("order_id")->comment("关联订单");
            $table->json("thumbs")->comment("图册，json");
            $table->text("data")->comment("评论内容");
            $table->tinyInteger("stars")->default(5)->comment("评论星级");
            $table->tinyInteger("status")->default(0)->comment("审核状态");
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
        Schema::dropIfExists('comment');
    }
}
