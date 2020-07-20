<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('opendid')->comment("微信用户openid");
            $table->string("avatar")->comment("wx 头像");
            $table->string("nickname")->comment("昵称");
            $table->string("city")->comment("");
            $table->string("province")->comment("");
            $table->float("amount")->comment("余额")->default('0.00');
            $table->float("freeze")->comment("冻结资金")->default('0.00');
            $table->integer("talent")->comment("达人用户ID")->default(0);
            $table->tinyInteger("status")->comment("状态")->default(0);
            $table->tinyInteger("gender")->comment("性别");
            $table->integer('loginTimes')->comment("登陆次数");
            $table->tinyInteger("type")->default(1)->comment("类型，1:普通，2：旅游团，3：达人");
            $table->string('session_key');
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
        Schema::dropIfExists('users');
    }
}
