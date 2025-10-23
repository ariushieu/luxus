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
        Schema::create('quotes', function (Blueprint $table) {
            $table->id();
            $table->string('client_name');
            $table->string('client_email');
            $table->string('client_phone');
            $table->string('project_type')->nullable(); // housing, commercial, office
            $table->decimal('budget', 15, 2)->nullable();
            $table->decimal('area', 10, 2)->nullable();
            $table->text('request_details');
            $table->enum('status', ['pending', 'reviewing', 'quoted', 'accepted', 'rejected'])->default('pending');
            $table->text('admin_notes')->nullable();
            $table->decimal('quoted_amount', 15, 2)->nullable();
            $table->timestamps();

            $table->index('client_email');
            $table->index('status');
            $table->index('project_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quotes');
    }
};
