<?php

/**
 * Adds SEO meta columns used by admin SEO sidebar + public SeoManager.
 * Schema: pages.meta_keywords; posts/projects/services.meta_title|meta_description|meta_keywords.
 * Callers: admin forms (pages, posts, projects, services) via Eloquent fillable.
 * User: "pastikan masing masing ada panel meta keyword auto generated dan meta tile serta google search preview for seo di sidebar"
 */

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pages', function (Blueprint $table): void {
            if (! Schema::hasColumn('pages', 'meta_keywords')) {
                $table->string('meta_keywords', 500)->nullable()->after('meta_description');
            }
        });

        Schema::table('posts', function (Blueprint $table): void {
            if (! Schema::hasColumn('posts', 'meta_title')) {
                $table->string('meta_title')->nullable()->after('excerpt');
            }
            if (! Schema::hasColumn('posts', 'meta_description')) {
                $table->string('meta_description', 500)->nullable()->after('meta_title');
            }
            if (! Schema::hasColumn('posts', 'meta_keywords')) {
                $table->string('meta_keywords', 500)->nullable()->after('meta_description');
            }
        });

        Schema::table('projects', function (Blueprint $table): void {
            if (! Schema::hasColumn('projects', 'meta_title')) {
                $table->string('meta_title')->nullable()->after('description');
            }
            if (! Schema::hasColumn('projects', 'meta_description')) {
                $table->string('meta_description', 500)->nullable()->after('meta_title');
            }
            if (! Schema::hasColumn('projects', 'meta_keywords')) {
                $table->string('meta_keywords', 500)->nullable()->after('meta_description');
            }
        });

        Schema::table('services', function (Blueprint $table): void {
            if (! Schema::hasColumn('services', 'meta_title')) {
                $table->string('meta_title')->nullable()->after('description');
            }
            if (! Schema::hasColumn('services', 'meta_description')) {
                $table->string('meta_description', 500)->nullable()->after('meta_title');
            }
            if (! Schema::hasColumn('services', 'meta_keywords')) {
                $table->string('meta_keywords', 500)->nullable()->after('meta_description');
            }
        });
    }

    public function down(): void
    {
        Schema::table('pages', function (Blueprint $table): void {
            if (Schema::hasColumn('pages', 'meta_keywords')) {
                $table->dropColumn('meta_keywords');
            }
        });

        foreach (['posts', 'projects', 'services'] as $tableName) {
            Schema::table($tableName, function (Blueprint $table) use ($tableName): void {
                foreach (['meta_title', 'meta_description', 'meta_keywords'] as $col) {
                    if (Schema::hasColumn($tableName, $col)) {
                        $table->dropColumn($col);
                    }
                }
            });
        }
    }
};
