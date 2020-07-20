<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrders extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders',function (Blueprint $table){
            $table->increments('id')->comment("订单ID");
            $table->integer('uid')->comment("订单用户");
            $table->string("app")->comment("项目APP");
            $table->string("detail")->comment("同步的详情，用于搜索");
            $table->integer("order_id")->comment("项目的订单ID");
            $table->integer("talent")->comment("达人用户UID");
            $table->integer("shared")->comment("分享用户的UID");
            $table->integer("status")->comment("订单状态");
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
        Schema::dropIfExists('orders');
    }
}
