<?php
/**
 * 后台管理员的资金日志
 */
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdminMoneyLog extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('merchant_money_log', function (Blueprint $table) {
            $table->comment = '商家用户资金日志表';
            $table->increments('id');
            $table->integer('merchant_id');
            $table->float('amount')->default('0.00')->comment('当前账户余额');
            $table->float('affect')->default('0.00')->comment('变动金额');
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
        //
    }
}
