<?php

use Phpmig\Migration\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTestTable extends Migration
{
    /**
     * Do the migration
     */
    public function up()
    {
        $container = $this->getContainer();
        $db = $container['db'];
        $db::schema()->create('test', function (Blueprint $table) {
            $table->id();
            $table->json('body')->nullable();
            $table->string('method', 50);
            $table->string('userAgent');
            $table->string('acceptEncoding')->nullable();
            $table->string('xSignature')->nullable();
            $table->string('contentType')->nullable();
            $table->string('connection');
            $table->string('host');
            $table->string('queryString')->nullable();
            $table->string('contentLength')->nullable();
            $table->dateTime('dateTime');
        });
    }

    /**
     * Undo the migration
     */
    public function down()
    {
        $container = $this->getContainer();
        $db = $container['db'];
        $db::schema()->dropIfExists('test');
    }
}
