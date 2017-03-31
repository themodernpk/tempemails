<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTeMailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('te_mails', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('te_account_id')->nullable();
            $table->integer('uid')->nullable();
            $table->string('subject')->nullable();
            $table->text('message')->nullable();
            $table->text('message_text')->nullable();
            $table->text('message_raw')->nullable();
            $table->text('meta')->nullable();
            $table->boolean('read')->nullable();

            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->integer('deleted_by')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('te_mails');
    }
}
