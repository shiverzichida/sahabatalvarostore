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
        Schema::create('client_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->date('birth_date');
            $table->string('gender');
            $table->decimal('initial_height', 5, 2); // e.g., 175.50
            $table->decimal('initial_weight', 5, 2); // e.g., 70.20
            $table->decimal('initial_body_fat', 5, 2)->nullable();
            $table->string('goal')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('client_profiles');
    }
};
