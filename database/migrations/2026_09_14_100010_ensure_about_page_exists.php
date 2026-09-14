<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $about = [
            'title' => 'About Us',
            'slug' => 'about',
            'content' => '<h2>Our Story</h2><p>Founded in 2015, DesignPro has grown from a two-person design studio into a full-service digital agency. We\'ve helped over 200 businesses launch, grow, and transform with great design and robust engineering.</p><h2>Our Approach</h2><p>We believe great digital products are the result of deep understanding, disciplined process, and relentless iteration. Every project starts with research and ends with measurable results.</p>',
            'meta_title' => 'About DesignPro | Our Story & Team',
            'meta_description' => 'Learn about DesignPro\'s journey, our team of designers and developers, and the process we follow to deliver exceptional digital products.',
            'is_active' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ];

        if (! Schema::hasColumn('pages', 'meta_keywords')) {
            Schema::table('pages', function (Blueprint $table) {
                $table->text('meta_keywords')->nullable()->after('meta_description');
            });
        }

        DB::table('pages')->where('slug', 'about')->updateOrInsert(
            ['slug' => 'about'],
            $about
        );
    }

    public function down(): void
    {
        DB::table('pages')->where('slug', 'about')->delete();

        if (Schema::hasColumn('pages', 'meta_keywords')) {
            Schema::table('pages', function (Blueprint $table) {
                $table->dropColumn('meta_keywords');
            });
        }
    }
};
