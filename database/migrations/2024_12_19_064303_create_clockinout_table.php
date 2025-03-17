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
        Schema::create('userclockinout', function (Blueprint $table) {
            
            $table->id(); // Auto-incrementing primary key
            $table->unsignedBigInteger('user_id'); // Reference to the user who is clocking in/out
            $table->string('clock_in')->nullable(); // Time of clock-in (HH:mm:ss)
            $table->string('clock_out')->nullable(); // Time of clock-out (HH:mm:ss)
            $table->string('total_hours')->nullable(); // Total hours worked (optional)
            $table->date('date'); // Date of the clock-in/out (Y-m-d)
            $table->string('day'); // Day of the week (e.g., Monday, Tuesday)
            $table->timestamps(); // Created_at and updated_at timestamps

            // Adding a foreign key constraint if needed
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clockinout');
    }
};
