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
       Schema::create('websites', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained('users')->onDelete('cascade');
            $table->longText('url');
            $table->string('name')->nullable();
            $table->smallInteger('active')->default(1)->comment('0=Inactive, 1=Active');
            $table->integer('check_interval')->default(5)->comment('Check interval in minutes');
            $table->decimal('uptime_percentage', 5, 2)->default(0)->comment('Overall uptime percentage');
            $table->timestamp('last_checked_at')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index('client_id');
            $table->index('active');
        });


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('websites');
    }
};
