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
        Schema::table('senior_details', function (Blueprint $table) {
            //
            $table->dropColumn(['other_skills', 'staying_with_family', 'living_reason']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('senior_details', function (Blueprint $table) {
            //
            $table->string('other_skills')->nullable();
            $table->boolean('staying_with_family');
            $table->string('living_reason');
        });
    }
};
