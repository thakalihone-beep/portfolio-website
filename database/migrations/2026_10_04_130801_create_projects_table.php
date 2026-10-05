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

            $table->foreignId('user_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();

            $table->string('title');

            $table->string('slug')->unique();

            $table->string('short_description')->nullable();

            $table->longText('description')->nullable();

            $table->string('thumbnail')->nullable();

            $table->string('github_url')->nullable();

            $table->string('live_url')->nullable();

            $table->string('demo_url')->nullable();

            $table->string('status')->default('completed');

            $table->date('start_date')->nullable();

            $table->date('end_date')->nullable();

            $table->boolean('featured')->default(false);

            $table->boolean('is_published')->default(true);

            $table->unsignedInteger('sort_order')->default(0);

            $table->timestamps();

            $table->index('status');

            $table->index('featured');

            $table->index('is_published');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
