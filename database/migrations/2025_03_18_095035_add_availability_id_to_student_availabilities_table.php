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
        Schema::table('student_availabilities', function (Blueprint $table) {
            //
            $table->foreignId('availability_id')->nullable()->constrained('appointments')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('student_availabilities', function (Blueprint $table) {
            //
            $table->dropForeign(['availability_id']);
        });
    }
};
