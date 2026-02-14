<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('description');
            $table->text('long_description')->nullable();
            $table->json('tech_stack'); // ["Laravel", "Vue", "PostgreSQL"]
            $table->string('url')->nullable();
            $table->string('repo_url')->nullable();
            $table->string('screenshot_path')->nullable();
            $table->boolean('featured')->default(false);
            $table->boolean('is_visible')->default(true);
            $table->integer('sort_order')->default(0);
            $table->integer('year')->nullable();
            $table->string('status')->default('completed'); // completed, in_progress, archived
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
