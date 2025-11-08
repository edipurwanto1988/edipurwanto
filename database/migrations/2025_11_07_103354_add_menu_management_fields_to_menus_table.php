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
        Schema::table('menus', function (Blueprint $table) {
            $table->string('url')->nullable()->after('items');
            $table->foreignId('page_id')->nullable()->after('url')->constrained()->nullOnDelete();
            $table->string('target', 10)->default('_self')->after('page_id');
            $table->integer('order')->default(0)->after('target');
            $table->boolean('is_active')->default(true)->after('order');
            
            // Add indexes
            $table->index('order');
            $table->index('is_active');
            $table->index('page_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('menus', function (Blueprint $table) {
            $table->dropColumn(['url', 'page_id', 'target', 'order', 'is_active']);
        });
    }
};
