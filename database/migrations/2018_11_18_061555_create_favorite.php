<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFavorite extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('favorite',function (Blueprint $table){
            $table->increments('id');
            $table->integer('uid')->comment("收藏用户");
            $table->string('app')->comment("收藏类型");
            $table->integer('app_id')->comment("收藏ID");
            $table->integer('status')->comment("收藏状态。1，收藏。2，收藏后取消");
            $table->string("remark")->comment("备注信息");
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
        Schema::dropIfExists('favorite');
    }
}
