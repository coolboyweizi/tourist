<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateActive extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('active',function (Blueprint $table){
            $table->comment = '活动表';
            $table->increments('id');
            $table->float('price')->comment('活动价格');
            $table->string('app')->conment('相关项目');
            $table->integer('price_id')->comment('价格ID');
            $table->integer('stime')->default(0)->comment('开始时间');
            $table->integer('etime')->default(0)->comment('持续时间');
            $table->json('date')->comment('每个月的几号');
            $table->json('week')->comment('每周');
            $table->integer('number')->default(10000)->comment('数量');
            $table->string('remark')->default('备注')->comment('备注');
            $table->tinyInteger('status')->comment('状态')->default(1);
            $table->integer('deleted')->nullable();
            $table->integer('created');
            $table->integer('updated');
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
