<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('title')->nullable(); // e.g. "Full Stack Developer"
            $table->text('bio')->nullable();
            $table->string('avatar_path')->nullable();
            $table->string('resume_path')->nullable();
            $table->json('social_links')->nullable(); // {github, twitter, linkedin, etc}
            $table->string('status_text')->nullable(); // "Available for hire"
            $table->string('currently_reading')->nullable();
            $table->string('currently_building')->nullable();
            $table->string('currently_listening')->nullable();
            $table->string('location')->nullable();
            $table->string('email_public')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('profiles');
    }
};
