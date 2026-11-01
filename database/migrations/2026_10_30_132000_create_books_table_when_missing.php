<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('books')) {
            return;
        }

        Schema::create('books', function (Blueprint $table): void {
            $table->id();
            $table->string('title');
            $table->string('author');
            $table->string('isbn')->unique();
            $table->integer('year');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        // This compatibility migration preserves the table when rolling back.
    }
};
