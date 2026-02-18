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

        Schema::table('users', function (Blueprint $table) {
            //

            $table->foreignId('barangay_id')->constrained()->cascadeOnDelete()->after('id');
            $table->string('username')->unique()->after('name');
            $table->string('role')->after('username');
            $table->string('profile_pic')->after('role')->nullable();

            

            $table->dropColumn([
                'email',
                'email_verified_at'
            ]);


        });
        

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {

            //remove new add columns
            $table->dropColumn(['username', 'role', 'profile_pic','barangay_id']);

            // add old columns
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();

            
        });
        //
    }
};
