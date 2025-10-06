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
       Schema::create('entities', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['client', 'supplier']); 
            $table->unsignedBigInteger('number')->unique(); 
            $table->string('nif')->unique(); 
            $table->string('name');
            $table->string('address')->nullable();
            $table->string('postal_code', 8)->nullable(); 
            $table->string('city')->nullable();
            $table->foreignId('country_id')->constrained('countries');
            $table->string('phone')->nullable();
            $table->string('mobile')->nullable();
            $table->string('website')->nullable();
            $table->string('email')->nullable();
            $table->boolean('rgpd_consent')->default(false);
            $table->text('notes')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('entities');
    }
};
