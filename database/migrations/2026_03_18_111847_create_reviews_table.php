<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('formation_id')->nullable()->constrained('formations')->nullOnDelete();
            $table->string('reviewer_name');
            $table->string('reviewer_email')->nullable();
            $table->string('reviewer_job')->nullable()->comment('Poste / Profession');
            $table->string('reviewer_avatar')->nullable();
            $table->tinyInteger('rating')->default(5)->comment('1 à 5 étoiles');
            $table->text('comment');
            $table->boolean('is_approved')->default(false);
            $table->boolean('is_featured')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};