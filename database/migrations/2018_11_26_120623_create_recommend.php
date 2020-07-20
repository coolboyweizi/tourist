<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRecommend extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recommend',function (Blueprint $table){
            $table->increments("id");
            $table->string("app")->comment("推荐类型");
            $table->integer("app_id")->comment("推荐的项目");
            $table->integer("priority")->default(9)->comment("推荐优先级.9最低 1 最高");
            $table->string("data")->default("官方推荐")->comment("推荐理由");
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
        Schema::dropIfExists("recommend");
    }
}
