<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // Add reactions JSON column to store aggregate counts {"👍": 5, "❤️": 2}
        Schema::table('guest_book_entries', function (Blueprint $table) {
            $table->json('reactions')->nullable()->after('is_approved');
        });

        // Track individual reactions to prevent duplicate voting (by IP)
        Schema::create('guestbook_reactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('guest_book_entry_id')->constrained('guest_book_entries')->cascadeOnDelete();
            $table->string('emoji', 10);
            $table->string('ip_address', 45);
            $table->timestamps();

            $table->unique(['guest_book_entry_id', 'emoji', 'ip_address'], 'unique_reaction');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('guestbook_reactions');

        Schema::table('guest_book_entries', function (Blueprint $table) {
            $table->dropColumn('reactions');
        });
    }
};
