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
            $table->integer('contact_id');
            $table->string('name');
            $table->string('email');
            $table->integer('account_id');
            $table->unique(['email', 'account_id']);
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
