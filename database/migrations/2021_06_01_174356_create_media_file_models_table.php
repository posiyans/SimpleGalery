<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMediaFileModelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('media_file_models', function (Blueprint $table) {
            $table->id();
            $table->integer('gallery_id')->comment('id галереи');
            $table->string('hash')->nullable()->comment('хеш файла');
            $table->string('path')->unique()->comment('путь к файлу');
            $table->string('type')->comment('тип файла');
            $table->string('size')->comment('размер файла');
            $table->string('name')->comment('имя файла');
            $table->string('user_id')->nullable()->comment('кто загрузил файл');
            $table->timestamp('date')->nullable()->comment('дата создания файла');
            $table->json('exif')->default(null)->comment('exif файла');
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
        Schema::dropIfExists('media_file_models');
    }
}
