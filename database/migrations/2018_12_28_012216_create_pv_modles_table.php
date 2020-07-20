<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePvModlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('daily_pv', function (Blueprint $table) {
            $table->increments('id');
            $table->string('dated')->comment('当前PV日期');
            $table->string('times')->comment('当前PV时间');
            $table->integer('count')->default('0')->comment('当前PV总计');
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
        Schema::dropIfExists('daily_pv');
    }
}
