<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangesToTeMailsTable extends Migration
{


    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('te_mails', function (Blueprint $table) {
            $table->dateTime('received_at')->nullable()->after('te_account_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('te_mails', function (Blueprint $table) {
            $table->dropColumn('received_at');
        });
    }
}
