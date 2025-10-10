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
        Schema::table('articles', function (Blueprint $table) {
            // Drop old foreign key and column if exists
            if (Schema::hasColumn('articles', 'vate-rate-id')) {
                $table->dropForeign(['vate-rate-id']);
                $table->renameColumn('vate-rate-id', 'vat_rate_id');
                $table->foreign('vat_rate_id')->references('id')->on('vat_rates');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('articles', function (Blueprint $table) {
            if (Schema::hasColumn('articles', 'vat_rate_id')) {
                $table->dropForeign(['vat_rate_id']);
                $table->renameColumn('vat_rate_id', 'vate-rate-id');
                $table->foreign('vate-rate-id')->references('id')->on('vat_rates');
            }
        });
    }
};
