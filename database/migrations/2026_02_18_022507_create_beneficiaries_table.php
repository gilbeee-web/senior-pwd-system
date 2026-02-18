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
        Schema::create('beneficiaries', function (Blueprint $table) {
            $table->id();
            
            $table->foreignId('beneficiary_address_id')->constrained()->cascadeOnDelete();
            $table->string('type');
            $table->string('last_name');
            $table->string('first_name');
            $table->string('middle_name');
            $table->string('extension')->nullable();
            $table->string('birthdate');
            $table->string('contact_number');
            $table->string('civil_status');
            $table->string('gender');
            $table->string('life_status');
            $table->string('residence_status');

            $table->foreignId('created_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->foreignId('updated_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();



            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('beneficiaries');
    }
};
