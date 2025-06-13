<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('administrateurs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users', 'id');
            $table->string('nom');
            $table->string('prenom');
            $table->string('contact')->unique();
            $table->string('email')->unique();
            $table->string('adresse')->nullable();
            $table->string("genre");
            $table->string("lien_photo")->nullable();
            $table->enum('disponibilite', ['hors ligne', 'en ligne'])->default('hors ligne');
            $table->enum('status', [1, 2])->default(1);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('administrateurs');
    }
};
