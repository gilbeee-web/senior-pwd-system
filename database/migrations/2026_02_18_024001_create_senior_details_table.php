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
        Schema::create('senior_details', function (Blueprint $table) {
            $table->id();

            $table->string('osca_id_number')->unique();
            $table->foreignId('beneficiary_id')->constrained()->cascadeOnDelete();
            $table->string('ncsc_registration_number')->nullable();
            $table->string('place_of_birth');
            $table->string('occupation');
            $table->string('other_skills')->nullable();
            $table->boolean('receives_pension');
            $table->bigInteger('pension_amount')->nullable();
            $table->boolean('staying_with_family')->default(false);
            $table->string('living_reason')->nullable();


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('senior_details');
    }
};
