<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersMoneyLog extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists("users_money_log");

        Schema::create('users_money_log', function (Blueprint $table) {
            $table->comment = '用户资金日志';
            $table->increments('id');
            $table->integer('uid');
            $table->float('amount')->default('0.00')->comment('当前账户余额');
            $table->float('affect')->default('0.00')->comment('流动金额');
            $table->float('freeze')->default('0.00')->comment('冻结金额');
            $table->string("app")->comment('对应app，withdraw为提现');
            $table->integer('app_id')->comment('app_id');
            $table->string('remark')->default('');
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
        Schema::dropIfExists("users_money_log");
    }
}
