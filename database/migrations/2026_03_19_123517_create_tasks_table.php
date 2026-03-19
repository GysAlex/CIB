<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained()->onDelete('cascade');
            $table->foreignId('creator_id')->constrained('users'); // L'admin/staff qui crée
            $table->string('title');
            $table->text('description')->nullable();
            $table->enum('priority', ['basse', 'normale', 'haute', 'critique'])->default('normale');
            $table->enum('status', ['a_faire', 'en_cours', 'en_attente_validation', 'valide'])->default('a_faire');
            $table->date('deadline');

            // Pour la checklist, on peut utiliser un champ JSON si on veut rester simple
            // ou une table séparée si on veut des statistiques par objectif.
            $table->json('checklist')->nullable();

            $table->timestamps();
        });

        Schema::create('task_user', function (Blueprint $table) {
            $table->id();
            $table->foreignId('task_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('task_user');
        Schema::dropIfExists('tasks');

    }
};
