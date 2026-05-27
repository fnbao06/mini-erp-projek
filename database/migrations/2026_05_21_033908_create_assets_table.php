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
        Schema::create('assets', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->date('purchase_date');
            $table->integer('purchase_price');
            $table->foreignId('purchase_transaction_id')->nullable()->constrained('transactions')->onDelete('set null');
            
            $table->date('sale_date')->nullable();
            $table->integer('sale_price')->nullable();
            $table->foreignId('sale_transaction_id')->nullable()->constrained('transactions')->onDelete('set null');
            
            $table->enum('status', ['owned', 'sold'])->default('owned');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assets');
    }
};
