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
        Schema::create('supplier_order_lines', function (Blueprint $table) {
            $table->id();
            $table->foreignId('article_id')->constrained('articles');
            $table->foreignId('supplier_id')->nullable()->constrained('entities');
            $table->foreignId('order_line_id')->nullable()->constrained('order_lines')->onDelete('set null');
            $table->integer('quantity');
            $table->decimal('price', 12, 2);
            $table->decimal('cost_price', 12, 2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('supplier_order_lines');
    }
};
