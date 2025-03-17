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
        Schema::create('userleave', function (Blueprint $table) {


            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            
            $table->date('start_date');
            $table->string('start_day_type');
            $table->date('end_date');
            $table->string('end_day_type');
            $table->text('reason')->nullable();
            $table->foreignId('approved_by')->nullable()->constrained('users')->onDelete('set null');
            
            $table->string('status')->default('Pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('userleaves');
    }
};
