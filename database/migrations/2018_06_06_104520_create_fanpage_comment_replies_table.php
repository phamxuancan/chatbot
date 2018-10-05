<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFanpageCommentRepliesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fanpage_comment_replies', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->string('fanpage_id');
            $table->string('post_id');
            $table->string('keywords');
            $table->string('message');
            $table->tinyInteger('is_giftcode');
            $table->index(array('fanpage_id','post_id'));
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
        Schema::dropIfExists('fanpage_comment_replies');
    }
}
