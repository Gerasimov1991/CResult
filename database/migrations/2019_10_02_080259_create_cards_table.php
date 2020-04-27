<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cards', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user_id')->unsigned();
            $table->integer('branch_id')->unsigned();
            $table->integer('package_id')->unsigned();
            $table->string('name');
            $table->string('title');
            $table->string('mobile');
            $table->string('direct_dial');
            $table->string('email');
            $table->string('image');
            $table->tinyInteger('status');
            $table->string('name_font_size')->nullable();
            $table->string('name_font_weight')->nullable();
            $table->string('title_font_size')->nullable();
            $table->string('title_font_weight')->nullable();
            $table->string('main_font_size')->nullable();
            $table->string('main_color')->nullable();
            $table->string('sub_color')->nullable();
            $table->string('font_name')->nullable();
            $table->string('image_size')->nullable();
            $table->string('image_top_margin')->nullable();
            $table->string('image_right_margin')->nullable();
            $table->string('margin_top')->nullable();
            $table->string('margin_bottom')->nullable();
            $table->string('footer_font_size')->nullable();
            $table->string('proof')->nullable();
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
        Schema::dropIfExists('cards');
    }
}
