<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('note_files', function (Blueprint $table) {
            $table->id();

            $table->foreignId('note_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->string('name');
            $table->string('note_image')->nullable();
            $table->string('file_path');

            $table->string('file_type')->nullable();
            $table->unsignedBigInteger('file_size')->nullable();

            $table->string('description')->nullable();

            $table->unsignedInteger('sort_order')->default(0);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('note_files');
    }
};
