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
          Schema::create('monitoring_process_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('website_id')->constrained('websites')->onDelete('cascade');
            $table->timestamp('last_monitored')->useCurrent();
            $table->enum('status', ['up', 'down'])->default('up');
            $table->integer('status_code')->nullable()->comment('HTTP status code');
            $table->integer('response_time')->nullable()->comment('Response time in milliseconds');
            $table->longText('failure_error')->nullable();
            $table->longText('response_body')->nullable()->comment('Response body for debugging');
            $table->timestamps();

            $table->index('client_id');
            $table->index('website_id');
            $table->index('status');
            $table->index('last_monitored');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('monitoring_process_logs');
    }
};
