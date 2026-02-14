<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('visitor_badges', function (Blueprint $table) {
            $table->id();
            $table->string('visitor_hash'); // hashed IP or fingerprint
            $table->string('badge_slug');
            $table->timestamp('earned_at');
            $table->timestamps();

            $table->unique(['visitor_hash', 'badge_slug']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('visitor_badges');
    }
};
