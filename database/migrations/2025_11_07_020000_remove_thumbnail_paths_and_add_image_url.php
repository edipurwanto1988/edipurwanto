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
        Schema::table('articles', function (Blueprint $table) {
            // Drop the old thumbnail path fields
            $table->dropColumn(['thumbnail_path', 'thumbnail_thumb_path']);
            
            // Rename thumbnail_url to image_url if it exists, or add image_url if it doesn't
            if (Schema::hasColumn('articles', 'thumbnail_url')) {
                $table->renameColumn('thumbnail_url', 'image_url');
            } else {
                $table->string('image_url')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('articles', function (Blueprint $table) {
            // Add back the old fields
            $table->string('thumbnail_path')->nullable()->after('excerpt');
            $table->string('thumbnail_thumb_path')->nullable()->after('thumbnail_path');
            
            // Rename image_url back to thumbnail_url
            if (Schema::hasColumn('articles', 'image_url')) {
                $table->renameColumn('image_url', 'thumbnail_url');
            }
        });
    }
};