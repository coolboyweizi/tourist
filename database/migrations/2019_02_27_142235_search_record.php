<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SearchRecord extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('search_record',function (Blueprint $table){
            // 搜索记录
            $table->comment = '搜索记录表';
            $table->increments('id');
            $table->string('app')->comment('模块');
            $table->string('keywords')->comment('搜索关键字');
            $table->integer('times')->comment('记录日期');
            $table->integer('count')->comment('搜索次数')->default(0);
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
