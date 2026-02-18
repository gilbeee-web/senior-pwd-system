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
        Schema::create('pwd_details', function (Blueprint $table) {
            $table->id();

            $table->string('pwd_id_number')->unique();
            $table->foreignId('beneficiary_id')->constrained()->cascadeOnDelete();
            $table->string('disability_type');
            $table->string('guardian_name');
            $table->string('blood_type');
            $table->string('educational_attainment');
            $table->string('date_id_issued');
            $table->string('date_id_expiration');
            $table->boolean('is_middleclass');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pwd_details');
    }
};
