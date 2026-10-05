<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('educations', function (Blueprint $table) {
            $table->id();

            $table->string('degree');

            $table->string('field_of_study')->nullable();

            $table->string('institution');

            $table->string('institution_logo')->nullable();

            $table->string('institution_url')->nullable();

            $table->string('location')->nullable();

            $table->text('description')->nullable();

            $table->date('start_date')->nullable();

            $table->date('end_date')->nullable();

            $table->boolean('is_current')->default(false);

            $table->string('grade')->nullable();

            $table->unsignedInteger('sort_order')->default(0);

            $table->timestamps();

            $table->index('is_current');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('educations');
    }
};
