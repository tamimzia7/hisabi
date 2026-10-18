<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('workspaces', function (Blueprint $table) {
            $table->id();
            $table->foreignId('owner_id')->constrained('users')->cascadeOnDelete();
            $table->string('type', 20); // personal, mess, business
            $table->string('name');
            $table->json('settings')->nullable();
            $table->timestamps();

            $table->index(['owner_id', 'type']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('workspaces');
    }
};
