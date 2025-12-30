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
        Schema::create('mail_notification_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained('users')->onDelete('cascade');
            $table->string('email');
            $table->foreignId('website_id')->constrained('websites')->onDelete('cascade');
            $table->timestamp('email_sent_on')->useCurrent();
            $table->boolean('is_delivered')->default(false);
            $table->text('failure_message')->nullable();
            $table->text('email_message');
            $table->string('email_subject');
            $table->enum('notification_type', ['down', 'up', 'slow', 'ssl_expiry'])->default('down');
            $table->timestamps();

            $table->index('client_id');
            $table->index('website_id');
            $table->index('email');
            $table->index('is_delivered');
            $table->index('email_sent_on');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mail_notification_logs');
    }
};
