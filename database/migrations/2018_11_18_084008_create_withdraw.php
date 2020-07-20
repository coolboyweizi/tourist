<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWithdraw extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('withdraw',function (Blueprint $table){
            $table->increments('id');
            $table->integer('uid')->comment("提现用户");
            $table->float('money')->comment("提现金额");
            $table->integer('status')->default(0)->comment("提现状态：-1、失效。0、已经申请。1、受理中。2、已提现");
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
        Schema::dropIfExists("withdraw");
    }
}
