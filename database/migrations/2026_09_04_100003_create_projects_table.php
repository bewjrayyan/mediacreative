<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('category')->index();
            $table->string('client')->nullable();
            $table->string('thumbnail')->nullable();
            $table->json('gallery_images')->nullable();
            $table->text('description');
            $table->json('technologies')->nullable();
            $table->string('url')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->string('status')->default('draft'); // draft / published
            $table->json('services')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['is_featured', 'status', 'category']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
