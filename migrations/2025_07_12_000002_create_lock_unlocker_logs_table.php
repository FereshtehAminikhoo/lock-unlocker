<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('lock_unlocker_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('lock_unlocker_id')->nullable();
            $table->string('model_name');
            $table->unsignedBigInteger('model_id');
            $table->enum('action', ['lock', 'unlock']);
            $table->boolean('is_lock')->default(false);
            $table->timestamp('lock_expired_at')->nullable();
            $table->enum('creator_name', ['user', 'job'])->nullable();
            $table->unsignedBigInteger('creator_id')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lock_unlocker_logs');
    }
};
