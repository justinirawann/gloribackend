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
        Schema::table('contact_info', function (Blueprint $table) {
            $table->dropColumn(['facebook', 'linkedin', 'maps_embed_url']);
            $table->string('email_name')->after('email');
            $table->string('phone_name')->after('phone');
            $table->string('instagram_name')->nullable()->after('instagram');
            $table->string('whatsapp')->nullable()->after('instagram_name');
            $table->string('whatsapp_name')->nullable()->after('whatsapp');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('contact_info', function (Blueprint $table) {
            $table->dropColumn(['email_name', 'phone_name', 'instagram_name', 'whatsapp', 'whatsapp_name']);
            $table->string('facebook')->nullable();
            $table->string('linkedin')->nullable();
            $table->string('maps_embed_url')->nullable();
        });
    }
};
