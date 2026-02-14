<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('page_views', function (Blueprint $table) {
            $table->id();
            $table->string('url');
            $table->string('page_title')->nullable();
            $table->string('referrer')->nullable();
            $table->string('ip_hash', 64);
            $table->string('user_agent')->nullable();
            $table->date('viewed_date');
            $table->timestamps();

            $table->index(['url', 'viewed_date']);
            $table->index('viewed_date');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('page_views');
    }
};
