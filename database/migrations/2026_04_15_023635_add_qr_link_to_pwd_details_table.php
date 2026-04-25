<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('pwd_details', function (Blueprint $table) {
            //
            $table->string('qr_link')->nullable()->after('date_id_expiration');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pwd_details', function (Blueprint $table) {
            //
            $table->dropColumn('qr_link');
        });
    }
};
