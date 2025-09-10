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
        Schema::create('criteria_ranges', function (Blueprint $table) {
            $table->id();
            $table->foreignId('criteria_id')->constrained('criterias')->cascadeOnDelete();
            $table->integer('min');
            $table->integer('max');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('criteria_ranges');
    }
};
