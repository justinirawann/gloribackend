<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('testimonials', function (Blueprint $table) {
            $table->decimal('rating', 3, 1)->default(5.0)->change();
        });
    }

    public function down(): void {
        Schema::table('testimonials', function (Blueprint $table) {
            $table->tinyInteger('rating')->default(5)->change();
        });
    }
};
