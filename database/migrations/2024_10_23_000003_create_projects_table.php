<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->string('title_vi');
            $table->string('title_en');
            $table->string('slug')->unique();
            $table->text('description_vi')->nullable();
            $table->text('description_en')->nullable();
            $table->text('content_vi')->nullable();
            $table->text('content_en')->nullable();
            $table->string('client_name')->nullable();
            $table->string('location')->nullable();
            $table->decimal('area', 10, 2)->nullable(); // Diện tích (m2)
            $table->integer('year')->nullable();
            $table->string('status')->default('completed'); // completed, ongoing, planned
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_active')->default(true);
            $table->integer('display_order')->default(0);
            $table->timestamps();

            $table->index('category_id');
            $table->index('slug');
            $table->index(['is_featured', 'is_active']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
