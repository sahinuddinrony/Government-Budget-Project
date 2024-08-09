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
        Schema::create('charges', function (Blueprint $table) {
            $table->id();
            $table->string('fiscal_year');
            $table->decimal('bank_charge', 15, 2);
            $table->decimal('check_fee', 15, 2);
            $table->integer('unspent_refund');
            // $table->foreignId('user_id')->constrained()->onDelete('cascade');
            // $table->foreignId('budget_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            // $table->foreignId('budget_id')->constrained()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('charges');
    }
};
