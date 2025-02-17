<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('things', function (Blueprint $table) {
            $table->id();
            $table->string('path_to_img');
            $table->foreignId('material_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('drawing_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('things');
    }
};

