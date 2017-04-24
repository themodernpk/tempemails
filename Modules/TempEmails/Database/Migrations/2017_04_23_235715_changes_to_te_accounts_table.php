<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangesToTeAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('te_accounts', function (Blueprint $table) {
            $table->dateTime('expired_at')->nullable()->after('hours');
            $table->boolean('expired')->nullable()->after('hours');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('te_accounts', function (Blueprint $table) {
            $table->dropColumn('expired_at');
            $table->dropColumn('expired');
        });
    }
}
