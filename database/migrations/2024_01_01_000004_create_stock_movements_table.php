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
        Schema::create('stock_movements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->enum('type', ['in', 'out', 'adjustment', 'return', 'repair'])->comment('Type of stock movement');
            $table->integer('quantity')->comment('Positive for in, negative for out');
            $table->integer('previous_stock')->comment('Stock level before movement');
            $table->integer('new_stock')->comment('Stock level after movement');
            $table->string('reference')->nullable()->comment('Reference number for the movement');
            $table->text('notes')->nullable();
            $table->foreignId('user_id')->constrained();
            $table->timestamp('movement_date');
            $table->timestamps();
            
            $table->index(['product_id', 'movement_date']);
            $table->index(['type', 'movement_date']);
            $table->index('user_id');
            $table->index('reference');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stock_movements');
    }
};