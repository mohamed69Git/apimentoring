<?php

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
        Schema::create('formations', function (Blueprint $table) {
            $table->id();
            $table->string("label")->unique();
            $table->enum("plan", ["free", "paid"]);
            $table->enum("level", ["beginner", "confirmed", "expert"])->default('beginner');
            $table->foreignIdFor(User::class)->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->string('description')->nullable();
            $table->enum('state', ['on-going', 'finished', 'waiting'])->default('waiting');
            $table->foreignIdFor(Calendar::class)->constrained()->onUpdate(null)->onDelete(null);
            $table->foreignIdFor(CategoryFormation::class)->constrained()->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('formations');
    }
};
