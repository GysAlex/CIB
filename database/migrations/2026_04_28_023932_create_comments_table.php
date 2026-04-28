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
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable();

            // Les colonnes polymorphiques
            $table->unsignedBigInteger('commentable_id');
            $table->string('commentable_type');

            $table->text('content');
            $table->boolean('is_approved')->default(false);

            // On ajoute les infos pour les invités
            $table->string('guest_name')->nullable();
            $table->string('guest_email')->nullable();

            $table->timestamps();


        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comments');
    }
};
