<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCoreEmailAlertsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('core_email_alerts', function (Blueprint $table) {
	        $table->increments('id');
	        $table->string('type')->nullable();
	        $table->string('label')->nullable();
	        $table->integer('core_user_id')->nullable();
	        $table->string('from')->nullable();
	        $table->string('to')->nullable();
	        $table->string('subject')->nullable();
	        $table->text('message')->nullable();
	        $table->text('meta');
	        $table->timestamp('read_at')->nullable();
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
        Schema::dropIfExists('core_email_alerts');
    }
}
