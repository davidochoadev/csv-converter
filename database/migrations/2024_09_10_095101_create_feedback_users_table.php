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
        Schema::create('feedback_users', function (Blueprint $table) {
            $table->id();
            $table->string('type_form', 255)->nullable();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('phone_number');
            $table->boolean('first_consent')->nullable();
            $table->boolean('second_consent')->nullable();
            $table->boolean('third_consent')->nullable();
            $table->string('response_type')->nullable();
            $table->string('start_date')->nullable();
            $table->string('submit_date')->nullable();
            $table->string('stage_date')->nullable();
            $table->string('network_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('feedback_users');
    }
};
