<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProfit extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profit',function (Blueprint $table){
            $table->increments('id');
            $table->integer('order_id');
            $table->string('app')->comment('app类型');
            $table->float('sale')->comment('卖出价格');
            $table->integer('shared_uid')->comment("分享者ID");
            $table->integer("talent_uid")->comment("达人UID");
            $table->integer('merchant_id')->comment('商家id');
            $table->float('system')->comment('系统收成');
            $table->float('shared')->comment('分享提成');
            $table->float('talent')->comment('达人提成');
            $table->float('merchant')->comment('商家收益');
            $table->string("remark")->comment('系统备注');
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
        Schema::dropIfExists('profit');
    }
}
