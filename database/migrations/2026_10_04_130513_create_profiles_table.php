<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('profiles', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->string('name');

            $table->string('headline')->nullable();

            $table->text('bio')->nullable();

            $table->string('profile_image')->nullable();

            $table->string('cover_image')->nullable();

            $table->string('email')->nullable();

            $table->string('phone')->nullable();

            $table->string('location')->nullable();

            $table->string('resume')->nullable();

            $table->string('availability')->nullable();

            $table->boolean('is_active')->default(true);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('profiles');
    }
};
