<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('proposals', function (Blueprint $table) {
            $table->id();
            $table->string('number')->unique();
            $table->date('date');
            $table->foreignId('client_id')->constrained('entities');
            $table->date('valid_until');
            $table->decimal('total', 12, 2)->default(0);
            $table->enum('status', ['draft', 'closed'])->default('draft');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('proposals');
    }
};
