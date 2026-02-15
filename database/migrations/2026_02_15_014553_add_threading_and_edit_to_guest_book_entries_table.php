<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('guest_book_entries', function (Blueprint $table) {
            $table->foreignId('parent_id')->nullable()->constrained('guest_book_entries')->nullOnDelete();
            $table->string('edit_token', 64)->nullable()->index();
        });
    }

    public function down(): void
    {
        Schema::table('guest_book_entries', function (Blueprint $table) {
            $table->dropForeign(['parent_id']);
            $table->dropColumn(['parent_id', 'edit_token']);
        });
    }
};
