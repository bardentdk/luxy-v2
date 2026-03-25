<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('formation_sessions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('formation_id')->constrained('formations')->cascadeOnDelete();
            $table->string('label')->nullable()->comment('Ex: Session printemps 2026');
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->string('schedule')->nullable()->comment('Ex: Lundi/Mercredi 18h-20h');
            $table->string('location')->nullable()->comment('Ex: Saint-Denis ou En ligne');
            $table->string('modality')->default('presentiel')->comment('presentiel|distanciel|hybride');
            $table->unsignedInteger('seats_total')->nullable();
            $table->unsignedInteger('seats_taken')->default(0);
            $table->decimal('price_override', 10, 2)->nullable()->comment('Prix spécifique à cette session');
            $table->boolean('is_open')->default(true)->comment('Inscriptions ouvertes');
            $table->boolean('is_published')->default(true);
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->index(['formation_id', 'start_date']);
            $table->index('is_published');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('formation_sessions');
    }
};