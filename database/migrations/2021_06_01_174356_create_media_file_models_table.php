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
            $table->string('hash')->nullable()->comment('хеш файла');
            $table->string('path')->comment('путь к файлу');
            $table->string('type')->comment('тип файла');
            $table->string('size')->comment('размер файла');
            $table->string('name')->comment('имя файла');
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
