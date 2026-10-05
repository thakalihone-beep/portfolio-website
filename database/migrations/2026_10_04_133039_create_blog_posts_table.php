<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('blog_posts', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();

            $table->foreignId('blog_category_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();

            $table->string('title');
            $table->string('slug')->unique();

            $table->string('excerpt')->nullable();

            $table->longText('content');

            $table->string('featured_image')->nullable();

            $table->string('status')->default('draft');

            $table->unsignedInteger('views')->default(0);

            $table->boolean('is_featured')->default(false);
            $table->boolean('allow_comments')->default(true);

            $table->timestamp('published_at')->nullable();

            $table->timestamps();

            $table->index('status');
            $table->index('is_featured');
            $table->index('published_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('blog_posts');
    }
};
