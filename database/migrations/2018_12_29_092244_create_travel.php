<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTravel extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('travel');
        Schema::dropIfExists('travel_price');
        Schema::dropIfExists('travel_order');

        //
        Schema::create('travel',function (Blueprint $table){
            $table->increments('id');               //主键id
            $table->string('title')->comment('直通车ProductName');
            $table->json('thumbs');            //图册
            $table->string('logo');              //logo
            $table->string('detail');            //项目详情
            $table->string('departure');         // 出发地
            $table->string('destination');      //目的地
            $table->integer('pcode')->comment("直通车产品code");
            $table->integer('ptype')->comment('直通车ProductType');
            $table->tinyInteger('status')->comment("状态")->default(0);
            $table->integer("comment")->default(0)->comment("项目评论");
            $table->integer("ordered")->default(0)->comment("已定数量");        //预定数量
            $table->integer("recommend")->default(0)->comment("推荐ID");
            $table->string("tagsA")->comment("标签A 不作搜索 作展示");
            $table->string("tagsB")->comment("标签B 不作搜索 作展示");
            $table->string("tagsC")->comment("标签A 不作搜索 作展示");
            $table->integer('deleted')->nullable();
            $table->integer("created")->default(0);
            $table->integer("updated")->default(0);

        });

        Schema::create('travel_price',function (Blueprint $table) {
            $table->increments('id');
            $table->integer('app_id')->comment("项目ID");
            $table->integer('pcode');
            $table->string("title")->comment("票价显示");
            $table->float('price')->comment("售价");
            $table->string("type")->comment("票价类型");
            $table->string("unit")->comment("单位");
            $table->integer('godate')->nullable()->commernt('出发日期');
            $table->string('schedule')->comment('出发时刻');
            $table->integer('backdate')->nullable()->commernt('返回日期');
            $table->string('backSchedule')->nullable()->comment('返回时刻');
            $table->integer('seats')->comment('总座位数');
            $table->integer('occupiedseats')->comment('已售座位数');
            $table->integer('priority')->comment("优先级")->default(9);
            $table->integer('status')->comment('状态');
            $table->integer('deleted')->nullable();
            $table->integer('created');
            $table->integer('updated');
        });


        Schema::create('travel_order',function (Blueprint $table){
            $table->increments('id');
            $table->integer('uid')->comment('用户id');
            $table->integer("app_id")->comment("项目ID");
            $table->integer("price_id")->comment("项目价格ID");
            $table->string("detail",128)->comment("预定票价信息")->default('');
            $table->integer("number")->comment("购买数量");
            $table->float("money")->comment("购买单价");
            $table->float("amount")->comment("购买价格");
            $table->string("remark")->comment("预定备注");
            $table->string('pcode')->comment("产品code");
            $table->string('godate')->comment('出行时间');
            $table->string("schedule")->comment("出行时刻表");
            $table->integer('iscomment')->comment("评论");
            $table->tinyInteger("status")->comment("订单状态");
            $table->integer("shared")->comment("分享用户uid");
            $table->integer("talent")->comment("达人用户UID");
            $table->bigInteger("tel")->comment("预留号码");
            $table->string('apiShortUrl')->default('')->comment('api端的消费码页面短地址');
            $table->string('apiTag')->default('')->comment('客人消费码（验证码）');
            $table->string('apiOrder')->default('')->comment('api端的订单号');
            $table->string('apiNumber')->default('')->comment('我方的订单号');
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
        Schema::dropIfExists("travel");
    }
}
