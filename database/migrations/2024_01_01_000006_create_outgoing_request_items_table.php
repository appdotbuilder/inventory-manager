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
        Schema::create('outgoing_request_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('outgoing_request_id')->constrained()->onDelete('cascade');
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->integer('requested_quantity');
            $table->integer('approved_quantity')->nullable();
            $table->integer('fulfilled_quantity')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
            
            $table->index(['outgoing_request_id', 'product_id']);
            $table->index('product_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('outgoing_request_items');
    }
};