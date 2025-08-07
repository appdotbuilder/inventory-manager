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
        Schema::create('returns', function (Blueprint $table) {
            $table->id();
            $table->string('return_number')->unique();
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->integer('quantity');
            $table->enum('reason', ['defective', 'damaged', 'expired', 'overstocked', 'other']);
            $table->enum('condition', ['good', 'damaged', 'defective', 'expired']);
            $table->enum('action', ['restock', 'repair', 'dispose', 'return_to_supplier']);
            $table->text('notes')->nullable();
            $table->foreignId('returned_by')->constrained('users');
            $table->timestamp('returned_at');
            $table->timestamps();
            
            $table->index('return_number');
            $table->index(['product_id', 'returned_at']);
            $table->index(['reason', 'returned_at']);
            $table->index('returned_by');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('returns');
    }
};