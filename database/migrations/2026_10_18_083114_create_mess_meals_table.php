<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mess_meals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('workspace_id')->constrained('workspaces')->cascadeOnDelete();
            $table->foreignId('member_id')->constrained('workspace_members')->cascadeOnDelete();
            $table->date('meal_date');
            $table->unsignedTinyInteger('breakfast')->default(0);
            $table->unsignedTinyInteger('lunch')->default(0);
            $table->unsignedTinyInteger('dinner')->default(0);
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->unique(['member_id', 'meal_date']);
            $table->index(['workspace_id', 'meal_date']);
        });

        Schema::create('mess_expenses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('workspace_id')->constrained('workspaces')->cascadeOnDelete();
            $table->date('expense_date');
            $table->string('category', 30); // market, rent, gas, electricity, water, other
            $table->decimal('amount', 12, 2);
            $table->text('description')->nullable();
            $table->timestamps();

            $table->index(['workspace_id', 'expense_date']);
        });

        Schema::create('mess_deposits', function (Blueprint $table) {
            $table->id();
            $table->foreignId('workspace_id')->constrained('workspaces')->cascadeOnDelete();
            $table->foreignId('member_id')->constrained('workspace_members')->cascadeOnDelete();
            $table->decimal('amount', 12, 2);
            $table->date('deposit_date');
            $table->text('description')->nullable();
            $table->timestamps();

            $table->index(['workspace_id', 'deposit_date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mess_deposits');
        Schema::dropIfExists('mess_expenses');
        Schema::dropIfExists('mess_meals');
    }
};
