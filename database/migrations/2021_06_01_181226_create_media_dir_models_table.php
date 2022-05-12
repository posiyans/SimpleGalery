<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMediaDirModelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('media_dir_models', function (Blueprint $table) {
            $table->id();
            $table->string('path')->comment('путь к директории для сканирования');
            $table->string('name')->nullable()->comment('Название галереи');
            $table->integer('parent_id')->nullable()->comment('Id родительской галереи');
            $table->integer('user_id')->nullable()->comment('Id пользователя');
            $table->string('access')->default('private')->comment('тип доступа');
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
        Schema::dropIfExists('media_dir_models');
    }
}
