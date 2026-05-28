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
        Schema::create('vitamin_schedules', function (Blueprint $table) {
            $table->id();
            $table->string('client_name');
            $table->string('client_code')->index(); // Kode unik client (misal: SA-1234)
            $table->string('vitamin_name');
            $table->string('dosage'); // Misal: 500mg, 1 kapsul
            $table->date('start_date');
            $table->date('end_date');
            $table->string('frequency'); // daily, every_other_day, twice_weekly
            $table->string('days_of_week')->nullable(); // Contoh: "Monday,Thursday" jika twice_weekly
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vitamin_schedules');
    }
};
