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
            $table->uuid('uuid')->unique()->nullable();
            $table->string('fiscal_year');
            $table->decimal('allocation', 15, 2);
            $table->decimal('expenditure', 15, 2);
            $table->decimal('unused', 15, 2);
            $table->foreignId('user_id')->nullable()->constrained('users');
            $table->softDeletes();
            $table->foreignId('deleted_by')->nullable()->constrained('users');
            $table->timestamps();
            // $table->unique(['user_id', 'fiscal_year']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('budgets', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropForeign(['deleted_by']);
            $table->dropIfExists();

          });
    }
};
