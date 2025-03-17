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
        Schema::create('usercontact', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Name field
            $table->string('email')->unique(); // Email field, unique constraint
            $table->string('phoneno'); // Phone Number field
            $table->string('city'); // City field
            $table->string('country'); // Country field
            $table->timestamps(); // Created_at and Updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('usercontact');
    }
};
