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
        Schema::create('supplier_orders', function (Blueprint $table) {
            $table->id();
            $table->string('number')->unique();
            $table->date('date');
            $table->foreignId('supplier_id')->nullable()->constrained('entities');
            $table->foreignId('order_id')->constrained('orders')->onDelete('cascade');
            $table->date('valid_until')->nullable();
            $table->decimal('total', 12, 2)->default(0);
            $table->enum('status', ['draft', 'closed'])->default('draft');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('supplier_orders');
    }
};
