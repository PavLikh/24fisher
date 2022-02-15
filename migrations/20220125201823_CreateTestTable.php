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
            $table->json('body');
            $table->string('method', 50);
            $table->string('userAgent');
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
