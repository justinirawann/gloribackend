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
        Schema::table('services', function (Blueprint $table) {
            // Copy English descriptions to main description field
            // Then drop the Indonesian description and rename English to main
            $table->dropColumn('description');
        });
        
        Schema::table('services', function (Blueprint $table) {
            $table->renameColumn('description_en', 'description');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('services', function (Blueprint $table) {
            $table->renameColumn('description', 'description_en');
        });
        
        Schema::table('services', function (Blueprint $table) {
            $table->text('description')->after('name');
        });
    }
};
