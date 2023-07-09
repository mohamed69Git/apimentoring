<?php

use App\Models\CategoryFormation;
use App\Models\Demande;
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
        Schema::create('demande_categories', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(CategoryFormation::class);
            $table->foreignIdFor(Demande::class);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('demande_categories');
    }
};
