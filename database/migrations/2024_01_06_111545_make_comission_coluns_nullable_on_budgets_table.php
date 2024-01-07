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
        Schema::table('budgets', function (Blueprint $table) {
            $table->unsignedTinyInteger('commission')->nullable()->change();
            $table->date('first_payment_date')->nullable()->change();
            $table->unsignedTinyInteger('payment_term')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('budgets', function (Blueprint $table) {
            $table->unsignedTinyInteger('commission')->nullable(false)->change();
            $table->date('first_payment_date')->nullable(false)->change();
            $table->unsignedTinyInteger('payment_term')->nullable(false)->change();
        });
    }
};
