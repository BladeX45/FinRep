<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('account_id')->constrained()->onDelete('cascade');
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
             $table->foreignId('goal_id')->nullable()->constrained()->onDelete('set null');
            $table->date('transaction_date');
            $table->decimal('amount', 15, 2);
            $table->text('description')->nullable();
            $table->enum('transaction_type', ['Income', 'Expense', 'Transfer','Transfer-In', 'Transfer-Out']);
            $table->boolean('is_recurring')->default(false);
            $table->string('receipt_url')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
