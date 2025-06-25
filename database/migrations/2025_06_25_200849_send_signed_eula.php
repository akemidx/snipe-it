<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SendSignedEula extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('checkout_acceptances', function (Blueprint $table) {
            {
                $table->boolean('send_signed_eula')->nullable()->default(null);
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('checkout_acceptances', function (Blueprint $table) {
            if (Schema::hasColumn('checkout_acceptances', 'send_signed_eula')) {
                $table->dropColumn('send_signed_eula');
            }
        });
    }
}