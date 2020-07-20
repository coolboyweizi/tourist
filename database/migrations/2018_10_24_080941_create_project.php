<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProject extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // 项目
        Schema::create("project",function(Blueprint $table){
            $table->increments('id');
            $table->string("title")->comment("标题");
            $table->integer("merchant_id")->comment("后台商户UID");
            $table->text("thumbs")->comment("图册");
            $table->string('logo')->comment("logo");
            $table->text("detail")->comment("项目描述详情");
            $table->string("address")->comment("项目地址");
            $table->string("opentime")->comment("项目开放时间描述");
            //$table->integer("endtime")->comment("项目闭门时间");
            $table->tinyInteger('status')->default(0)->comment("项目状态");
            $table->text("notice")->comment("购买须知");
            $table->integer("ordered")->comment("已定数量");
            $table->integer("recommend")->default(0)->comment("推荐ID");
            $table->text("illustrate")->comment("项目说明");
            $table->integer("comment")->default(0)->comment("项目评论");
            $table->string("tagsA")->comment("标签A 不作搜索 作展示");
            $table->string("tagsB")->comment("标签B 不作搜索 作展示");
            $table->string("tagsC")->comment("标签A 不作搜索 作展示");
            $table->integer('deleted')->nullable();
            $table->integer("created")->default(0);
            $table->integer("updated")->default(0);
        });
        // 项目订单
        Schema::create('project_price',function (Blueprint $table){
            $table->increments('id');
            $table->integer('uid')->comment("用户UID");
            $table->integer('app_id')->comment("项目ID");
            $table->string("title")->comment("票价名称");
            $table->float('price')->comment("售价");
            $table->string("type")->comment("票价类型");
            $table->string("unit")->comment("单位");
            $table->string("tips")->comment("温馨提示");
            $table->integer('priority')->comment("优先级")->default(9);
            $table->integer('stime')->comment("有效时间");
            $table->integer('etime')->comment('失效时间');
            $table->integer('ext')->comment('当前活动数量');
            $table->integer('status')->comment('状态');
            $table->integer('deleted')->nullable();
            $table->integer("created")->default(0);
            $table->integer("updated")->default(0);
        });

        // 项目价格
        Schema::create('project_order',function(Blueprint $table){
            $table->increments("id");
            $table->integer('uid')->comment('id');
            $table->integer("app_id")->comment("项目ID");
            $table->integer("price_id")->comment("项目价格ID");
            $table->string("detail")->comment("预定票价信息");
            $table->integer("number")->comment("购买数量");
            $table->float("money")->comment("购买单价");
            $table->float("amount")->comment("购买价格");
            $table->string("remark")->comment("预定备注");
            $table->integer("usetime")->comment("出行时间");
            $table->bigInteger("umobile")->comment("预留号码");
            $table->tinyInteger("status")->comment("订单状态");
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
        Schema::dropIfExists("project");
    }
}
