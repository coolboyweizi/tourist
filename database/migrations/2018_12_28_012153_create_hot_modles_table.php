<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHotModlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hot', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('times')->comment('当前热搜时间');
            $table->integer('app_id')->comment('热搜ID');
            $table->string('app')->comment('当前热搜类型');
            $table->integer('count')->default(0)->comment('热搜总数');
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
        Schema::dropIfExists('hot');
    }
}
