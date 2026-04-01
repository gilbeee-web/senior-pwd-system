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
        Schema::create('senior_family_members', function (Blueprint $table) {
            $table->id();
            $table->foreignId('senior_detail_id')->constrained()->cascadeOnDelete();
            $table->string('full_name');
            $table->string('relationship');
            $table->date('birthdate');
            $table->string('civil_status')->nullable();
            $table->string('occupation')->nullable();
            $table->unsignedBigInteger('income');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('senior_family_members');
    }
};
