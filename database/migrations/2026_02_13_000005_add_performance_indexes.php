<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // blog_posts
        Schema::table('blog_posts', function (Blueprint $table) {
            $table->index('published_at', 'idx_bp_published_at');
            $table->index('is_published', 'idx_bp_is_published');
            $table->index('slug', 'idx_bp_slug');
        });

        // projects
        Schema::table('projects', function (Blueprint $table) {
            $table->index('is_visible', 'idx_proj_is_visible');
            $table->index('sort_order', 'idx_proj_sort_order');
            $table->index('year', 'idx_proj_year');
            $table->index('slug', 'idx_proj_slug');
        });

        // comments — parent_id already indexed via FK, add created_at
        Schema::table('comments', function (Blueprint $table) {
            $table->index('created_at', 'idx_comments_created_at');
        });

        // page_views — url+viewed_date already indexed, add created_at
        Schema::table('page_views', function (Blueprint $table) {
            $table->index('created_at', 'idx_pv_created_at');
        });
    }

    public function down(): void
    {
        Schema::table('blog_posts', function (Blueprint $table) {
            $table->dropIndex('idx_bp_published_at');
            $table->dropIndex('idx_bp_is_published');
            $table->dropIndex('idx_bp_slug');
        });

        Schema::table('projects', function (Blueprint $table) {
            $table->dropIndex('idx_proj_is_visible');
            $table->dropIndex('idx_proj_sort_order');
            $table->dropIndex('idx_proj_year');
            $table->dropIndex('idx_proj_slug');
        });

        Schema::table('comments', function (Blueprint $table) {
            $table->dropIndex('idx_comments_created_at');
        });

        Schema::table('page_views', function (Blueprint $table) {
            $table->dropIndex('idx_pv_created_at');
        });
    }
};
