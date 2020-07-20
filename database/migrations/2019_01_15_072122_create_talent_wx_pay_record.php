<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTalentWxPayRecord extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /** *      'appid' => 'wxbbb34fceedb03bc0',
         *      'bank_type' => 'CFT', 'cash_fee' => '1',
         *       'fee_type' => 'CNY',
         *       'is_subscribe' => 'N',
         *       'mch_id' => '1518216951',
         *       'nonce_str' => '5c0f28366b7ff',
         *       'openid' => 'o11975Tqf1J8033af2o-4FxW08SU',
         *       'out_trade_no' => '53',
         *       'result_code' => 'SUCCESS',
         *       'return_code' => 'SUCCESS',
         *       'sign' => '232AD95EBEC04C2BA2DACDCEF08E0657',
         *       'time_end' => '20181211110130',
         *       'total_fee' => '1',
         *       'trade_type' => 'JSAPI',
         *       'transaction_id' => '4200000222201812115220106322',
         */
        Schema::create('wx_pay_call_record',function (Blueprint $table){
            $table->increments('id');
            $table->tinyInteger('status')->comment('处理状态');
            $table->string('openid')->comment('用户openid');
            $table->string("nickname")->comment('用户当时昵称');
            $table->string('result_code')->comment('微信处理结果');
            $table->string("time_end")->comment('交易时间');
            $table->integer('total_fee')->comment('费用');
            $table->string("out_trade_no")->comment("交易号");
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
        //
    }
}
