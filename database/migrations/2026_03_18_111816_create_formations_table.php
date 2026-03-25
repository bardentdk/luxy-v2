<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('formations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->nullable()->constrained('formation_categories')->nullOnDelete();
            $table->foreignId('author_id')->constrained('users')->cascadeOnDelete();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('short_description')->nullable();
            $table->longText('content')->nullable()->comment('Contenu riche HTML');
            $table->string('thumbnail')->nullable();
            $table->string('banner')->nullable();
            $table->string('level')->default('debutant')->comment('debutant|intermediaire|avance|tous');
            $table->string('duration')->nullable()->comment('Ex: 3 mois, 40h');
            $table->decimal('price', 10, 2)->nullable();
            $table->decimal('price_promo', 10, 2)->nullable();
            $table->boolean('is_published')->default(false);
            $table->boolean('is_featured')->default(false);
            $table->boolean('has_certification')->default(false);
            $table->json('objectives')->nullable()->comment('Array of learning objectives');
            $table->json('prerequisites')->nullable()->comment('Array of prerequisites');
            $table->json('program')->nullable()->comment('Array of modules/chapters');
            $table->unsignedInteger('max_students')->nullable();
            $table->unsignedInteger('view_count')->default(0);
            $table->timestamp('published_at')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('formations');
    }
};