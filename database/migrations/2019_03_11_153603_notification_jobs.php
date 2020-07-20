<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class NotificationJobs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notification_jobs', function (Blueprint $table){
            $table->comment = '消息队列ForJobs异常';
            $table->increments('id');
            $table->string("jobs");
            $table->string('exception');
            $table->integer('deleted')->nullable();
            $table->integer('created')->nullable();
            $table->integer('updated')->nullable();
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
