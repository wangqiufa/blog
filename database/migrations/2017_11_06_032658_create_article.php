<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticle extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->increments('id')->comment('自增id');
            $table->unsignedInteger('cate_id')->comment('文章分类id');
            $table->unsignedInteger('lable_id')->comment('标签id');
            $table->string('title', 255)->comment('文章标题');
            $table->string('title_img', 255)->comment('文章标题缩略图');
            $table->mediumText('description')->comment('文章描述');
            $table->text('content')->comment('文章内容');
            $table->timestamps();
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
