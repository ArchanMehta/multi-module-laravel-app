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
        Schema::create('notifications', function (Blueprint $table) {
            // Primary UUID and type fields
            $table->uuid('id')->primary(); // UUID for notifications
            $table->string('type'); // Notification type (task, leave, etc.)

            // User-related fields
            $table->unsignedBigInteger('from_id');  // Sender's ID
            $table->unsignedBigInteger('to_id');  // Recipient's ID
            $table->unsignedBigInteger('post_id');  // Post ID (task/leave/faq ID)
            $table->string('title'); // Title of the notification
            $table->text('message'); // Message body
            $table->text('description')->nullable(); // Optional description

            // Morphs for notifiable relationships (such as User or any other entity)
            $table->morphs('notifiable');

            // Read-at timestamp and automatic timestamps
            $table->timestamp('read_at')->nullable(); // Read status timestamp
            $table->timestamps(); // Created and updated timestamps

            // Foreign key constraints for user relationships
            $table->foreign('from_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('to_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
