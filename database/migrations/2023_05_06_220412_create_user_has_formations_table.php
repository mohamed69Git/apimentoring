<?php

use App\Models\Formation;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_has_formations', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class)->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->foreignIdFor(Formation::class)->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mentor_has_formations');
    }
};
