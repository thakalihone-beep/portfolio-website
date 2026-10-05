<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('skills', function (Blueprint $table) {
            $table->id();

            $table->foreignId('skill_category_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->string('name');

            $table->string('slug')->unique();

            $table->string('icon')->nullable();

            $table->unsignedTinyInteger('proficiency')
                ->nullable();

            $table->unsignedInteger('years_of_experience')
                ->nullable();

            $table->text('description')->nullable();

            $table->unsignedInteger('sort_order')->default(0);

            $table->boolean('is_featured')->default(false);

            $table->boolean('is_active')->default(true);

            $table->timestamps();

            $table->index('is_featured');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('skills');
    }
};
