<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTalent extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('talent');
        Schema::dropIfExists('talent_order');
        Schema::dropIfExists('talent_list');
        Schema::dropIfExists('talent_price');
        Schema::dropIfExists('talent_user');
        Schema::dropIfExists('talent_group');


        Schema::create('talent',function (Blueprint $table){
            $table->comment = '达人线路';
            $table->increments('id');
            $table->integer('uid')->comment('达人用户');
            $table->string('title')->comment('定制标题');
            $table->string('logo')->comment('定制LOGO');
            $table->json('thumbs')->comment('定制相册');
            $table->string('departure')->comment('始发地');
            $table->string("destination")->comment('目的地');
            $table->string("detail")->comment('图文介绍');
            $table->integer('stime')->comment('开始时间');
            $table->integer('etime')->comment('失效时间');
            $table->integer('days')->comment('游玩天数');
            $table->integer('comment')->default('0')->comment('评论数量');
            $table->integer("recommend")->default(0)->comment("推荐ID");
            $table->integer('ordered')->default('0')->comment('订购数量');
            $table->tinyInteger('status')->comment('审核状态');
            $table->string('illustrate')->comment('行程说明');
            $table->integer('deleted')->nullable();
            $table->integer('created');
            $table->integer('updated');
        });

        Schema::create('talent_price',function (Blueprint $table){
            $table->comment = '达人定制价格';
            $table->increments('id');
            $table->integer('app_id');
            $table->string("title")->default('title')->comment("票价名称");
            $table->float('price')->default('0.00')->comment("售价");
            $table->string("unit")->comment("单位");
            $table->string("type")->default("达人定制");
            $table->integer('priority')->comment("优先级")->default(9);
            $table->integer('status')->comment('状态')->default(1);
            $table->integer('deleted')->nullable();
            $table->integer('created');
            $table->integer('updated');
        });

        Schema::create('talent_list',function (Blueprint $table){
            $table->comment = '达人线路列表';
            $table->increments('id');
            $table->integer('talent_id')->comment('达人线路ID');
            $table->string('app')->comment('关联的产品');
            $table->integer('price_id')->comment('票价ID号');
            $table->integer('number')->comment('票价数量');
            $table->integer('deleted')->nullable();
            $table->integer('created');
            $table->integer('updated');
        });

        Schema::create('talent_order',function (Blueprint $table){
            $table->comment = '达人订单';
            $table->increments("id");
            $table->integer("uid")->comment("项目ID");
            $table->integer("app_id")->comment("项目ID");
            $table->integer("price_id")->comment("项目价格ID");
            $table->string("detail")->comment("预定票价信息");
            $table->integer("number")->comment("购买数量");
            $table->float("money")->comment("购买单价");
            $table->float("amount")->comment("购买价格");
            $table->string("remark")->comment("预定备注");
            $table->bigInteger("umobile")->comment("预留号码");
            $table->string('username')->comment("预留用户名字");
            $table->string('godate')->comment("用户预计出行日");
            $table->tinyInteger("status")->comment("订单状态");
            $table->integer("shared")->comment("分享用户uid");
            $table->integer("talent")->comment("达人用户UID");
            $table->tinyInteger("iscomment")->default(0)->comment("是否评论");
            $table->integer("active_id")->comment("活动id")->default(0);
            $table->integer('deleted')->nullable();
            $table->integer("created");
            $table->integer("updated");
        });

        // 达人组
        Schema::create('talent_group', function (Blueprint $table){
            $table->comment = '达人用户组';
            $table->increments('id');
            $table->string('name')->comment('用户组名');
            $table->float('scale')->comment('达人比例');
            $table->tinyInteger('status')->comment('状态');
            $table->integer('deleted')->nullable();
            $table->integer("created");
            $table->integer("updated");
        });

        // 达人用户
        Schema::create('talent_user', function (Blueprint $table){
            $table->comment = '达人用户';
            $table->increments('id');
            $table->integer('uid');
            $table->integer('gid');
            $table->integer('deleted')->nullable();
            $table->integer("created");
            $table->integer("updated");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
