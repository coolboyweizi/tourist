<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBanner extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('banner', function (Blueprint $table) {
            $table->increments('id');
            $table->string("app")->comment("推荐类型");
            $table->integer("app_id")->comment("推荐的项目");
            $table->string("banner")->comment("banner图");
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
        Schema::dropIfExists('banner');
    }
}
