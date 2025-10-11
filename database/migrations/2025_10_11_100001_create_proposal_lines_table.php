<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('proposal_lines', function (Blueprint $table) {
            $table->id();
            $table->foreignId('proposal_id')->constrained('proposals')->onDelete('cascade');
            $table->foreignId('article_id')->constrained('articles');
            $table->foreignId('supplier_id')->nullable()->constrained('entities');
            $table->decimal('quantity', 10, 2);
            $table->decimal('price', 12, 2);
            $table->decimal('cost_price', 12, 2)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('proposal_lines');
    }
};
