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
        Schema::create('image_projets', function (Blueprint $table) {
            $table->id();
            $table->string("titre");
            $table->string("image");
            $table->string("description")->nullable();
            $table->foreignId('project_id')->constrained('projets')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('eimage_projets');
    }
};
