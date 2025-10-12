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
        Schema::table('supplier_order_lines', function (Blueprint $table) {
            $table->foreignId('supplier_order_id')->after('id')->constrained('supplier_orders')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('supplier_order_lines', function (Blueprint $table) {
            $table->dropForeign(['supplier_order_id']);
            $table->dropColumn('supplier_order_id');
        });
    }
};
