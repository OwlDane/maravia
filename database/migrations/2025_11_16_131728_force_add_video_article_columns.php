<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // ARTICLES TABLE ONLY (video feature removed)
        if (Schema::hasTable('articles')) {
            Schema::table('articles', function (Blueprint $table) {
                if (!Schema::hasColumn('articles', 'title')) {
                    $table->string('title')->after('id');
                }
                if (!Schema::hasColumn('articles', 'slug')) {
                    $table->string('slug')->after('title');
                }
                if (!Schema::hasColumn('articles', 'excerpt')) {
                    $table->string('excerpt', 500)->nullable()->after('slug');
                }
                if (!Schema::hasColumn('articles', 'content')) {
                    $table->longText('content')->nullable()->after('excerpt');
                }
                if (!Schema::hasColumn('articles', 'cover_image')) {
                    $table->string('cover_image')->nullable()->after('content');
                }
                if (!Schema::hasColumn('articles', 'is_published')) {
                    $table->boolean('is_published')->default(false)->after('cover_image');
                }
                if (!Schema::hasColumn('articles', 'published_at')) {
                    $table->timestamp('published_at')->nullable()->after('is_published');
                }
                if (!Schema::hasColumn('articles', 'author_id')) {
                    $table->unsignedBigInteger('author_id')->nullable()->after('published_at');
                }
            });
        }

        // Add unique constraint to articles slug if column exists
        try {
            if (Schema::hasColumn('articles', 'slug')) {
                Schema::table('articles', function (Blueprint $table) {
                    $table->unique('slug');
                });
            }
        } catch (Exception $e) {
            // Ignore if unique constraint already exists
        }
    }

    public function down(): void
    {
        // ARTICLES TABLE - Remove columns if they exist
        if (Schema::hasTable('articles')) {
            Schema::table('articles', function (Blueprint $table) {
                // Drop unique constraint first if it exists
                try {
                    $table->dropUnique(['slug']);
                } catch (Exception $e) {
                    // Ignore if constraint doesn't exist
                }
                
                $columns = ['author_id', 'published_at', 'is_published', 'cover_image', 'content', 'excerpt', 'slug', 'title'];
                foreach ($columns as $col) {
                    if (Schema::hasColumn('articles', $col)) {
                        $table->dropColumn($col);
                    }
                }
            });
        }
    }
};