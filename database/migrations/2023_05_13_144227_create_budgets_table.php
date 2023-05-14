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
        Schema::create('budgets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained('companies', 'id');
            $table->boolean('status');
            $table->unsignedTinyInteger('finish_month');
            $table->unsignedBigInteger('number');
            $table->unsignedTinyInteger('payment_type');
            $table->unsignedInteger('employees_number')->nullable();
            $table->decimal('measuring_area', 13, 2)->nullable();
            $table->decimal('value', 13, 2);
            $table->unsignedTinyInteger('commission');
            $table->date('first_payment_date');
            $table->unsignedTinyInteger('payment_term');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('budgets');
    }
};
