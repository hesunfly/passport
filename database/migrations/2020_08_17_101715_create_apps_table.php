<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('apps', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique();
            $table->string('app_name');
            $table->string('secret');
            $table->string('app_host');
            $table->unsignedTinyInteger('enabled')->default(0);
            $table->timestamps();
            $table->index('app_name');
            $table->comment('单点登录服务应用表');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('apps');
    }
}
