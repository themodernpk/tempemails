<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCoreNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('core_notifications', function (Blueprint $table) {
	        $table->uuid('id')->primary();
	        $table->string('type')->nullable();
	        $table->string('label')->nullable();
	        $table->integer('core_user_id')->nullable();
	        $table->string('title')->nullable();
	        $table->string('details')->nullable();
	        $table->string('link')->nullable();
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
        Schema::dropIfExists('core_notifications');
    }
}
