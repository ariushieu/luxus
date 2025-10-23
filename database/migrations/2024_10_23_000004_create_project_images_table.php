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
        Schema::create('project_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained()->onDelete('cascade');
            $table->string('cloudinary_public_id'); // ID để xóa/update trên Cloudinary
            $table->string('cloudinary_url'); // URL công khai
            $table->string('alt_text_vi')->nullable();
            $table->string('alt_text_en')->nullable();
            $table->boolean('is_primary')->default(false); // Ảnh đại diện
            $table->integer('display_order')->default(0);
            $table->timestamps();

            $table->index('project_id');
            $table->index(['project_id', 'is_primary']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('project_images');
    }
};
