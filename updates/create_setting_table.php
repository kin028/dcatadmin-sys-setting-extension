<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AdminSetting extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        if (Schema::hasTable('admin_settings')) {
            Schema::table("admin_settings", function(Blueprint $table){
                $table->string("title")->default("")->comment("标题");
                $table->string("type")->default("text")->nullable()->comment("类型");

            });
        }

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('admin_settings', function (Blueprint $table) {
            $table->dropColumn('title'); // 在回滚时删除字段
            $table->dropColumn('type'); // 在回滚时删除字段
        });
    }
};
