<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFanpageGiftcodeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fanpage_giftcodes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('fanpage_id');
            $table->string('title');
            $table->string('description');
            $table->string('count_code');
            $table->string('start_time');
            $table->string('end_time');
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
        Schema::dropIfExists('fanpage_giftcodes');
    }
}
