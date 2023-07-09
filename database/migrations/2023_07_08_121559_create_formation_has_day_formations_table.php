<?php

use App\Models\DaysFormation;
use App\Models\Formation;
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
        Schema::create('formation_has_day_formations', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(DaysFormation::class);
            $table->foreignIdFor(Formation::class);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('formation_has_day_formations');
    }
};
