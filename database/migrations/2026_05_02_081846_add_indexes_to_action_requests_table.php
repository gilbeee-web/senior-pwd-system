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
        Schema::table('action_requests', function (Blueprint $table) {
            //
            $table->index('type');
            $table->index('model_type');
            $table->index('created_at');

            $table->index(['status', 'model_type', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('action_requests', function (Blueprint $table) {

            $table->dropIndex('action_requests_type_index');
            $table->dropIndex('action_requests_model_type_index');
            $table->dropIndex('action_requests_created_at_index');

            $table->dropIndex('action_requests_status_model_type_created_at_index');
        });
    }
};
