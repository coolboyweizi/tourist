<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;


class CreateHotel extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hotel', function(Blueprint $table){
            $table->increments("id");
            $table->integer("merchant_id")->comment("后台商户UID");
            $table->string('title')->comment('酒店标题');
            $table->text('detail')->comment('酒店图文介绍');
            $table->string("logo")->comment("酒店LOGO");
            $table->tinyInteger('status')->comment("状态");
            $table->text("thumbs")->comment("酒店图册");
            $table->text('notice')->comment('预定须知');
            $table->integer("recommend")->default(0)->comment("推荐ID");
            $table->text("illustrate")->comment("项目说明");
            $table->integer("comment")->default(0)->comment("项目评论");
            $table->string("address")->comment("hotel地址");
            $table->integer("ordered")->comment("已定数量");
            $table->string("tagsA")->default('')->comment('标签A');
            $table->string("tagsB")->default('')->comment('标签B');
            $table->string("tagsC")->default('')->comment('标签C');
            $table->integer('deleted')->nullable();
            $table->integer("created")->default(0);
            $table->integer("updated")->default(0);
        });

        Schema::create('hotel_price', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('app_id')->comment('酒店系统ID');
            $table->string('title')->comment('标题');
            $table->string('type')->comment('房型');
            $table->float('price')->comment('酒店价格');
            $table->integer('priority')->comment('优先级');
            $table->string("thumbs")->comment("图册");
            $table->string("tags")->comment("标签");
            $table->tinyInteger("status")->comment("状态");
            $table->integer('deleted')->nullable();
            $table->integer("created")->default(0);
            $table->integer("updated")->default(0);
        });

        Schema::create('hotel_order', function (Blueprint $table)
        {
            $table->increments('id');
            $table->integer("uid");
            $table->integer("app_id");
            $table->integer('price_id')->comment('酒店价格ID');
            $table->string('detail')->comment('酒店下单详情');
            $table->integer('number')->comment('房间数量');
            $table->float('money')->comment('单价金额');
            $table->float("amount")->comment("订单总额");
            $table->string('remark')->comment('备注');
            $table->string("username")->comment("入住人的姓名");
            $table->bigInteger("umobile")->comment("联系电话");
            $table->integer('ustime')->comment('用户入驻时间');
            $table->integer('uetime')->comment('用户离房时间');
            $table->integer('status')->default(0)->comment('订单状态');
            $table->integer("shared")->comment("分享用户uid");
            $table->integer("talent")->comment("达人用户UID");
            $table->tinyInteger("iscomment")->default(0)->comment("是否评论");
            $table->integer("active_id")->comment("活动id")->default(0);
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
        Schema::dropIfExists('hotel');
    }
}
