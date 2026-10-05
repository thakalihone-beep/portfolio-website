<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('certifications', function (Blueprint $table) {
            $table->id();

            $table->string('name');

            $table->string('issuer');

            $table->string('issuer_logo')->nullable();

            $table->string('credential_id')->nullable();

            $table->string('credential_url')->nullable();

            $table->string('certificate_file')->nullable();

            $table->string('certificate_image')->nullable();

            $table->date('issue_date')->nullable();

            $table->date('expiry_date')->nullable();

            $table->boolean('does_not_expire')->default(false);

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
        Schema::dropIfExists('certifications');
    }
};
