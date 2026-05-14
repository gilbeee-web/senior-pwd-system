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
            $table->index('disability_type');
            $table->index('educational_attainment');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pwd_details', function (Blueprint $table) {
            $table->dropIndex(['beneficiary_id']);
            $table->dropIndex(['pwd_id_number']);
            $table->dropIndex(['disability_type']);
            $table->dropIndex(['educational_attainment']);
        });

        Schema::table('senior_details', function (Blueprint $table) {
            $table->dropIndex(['beneficiary_id']);
            $table->dropIndex(['osca_id_number']);
        });

    }
};
