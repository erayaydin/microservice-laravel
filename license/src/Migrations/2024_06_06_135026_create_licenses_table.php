<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('licenses', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('user_id');
            $table->enum('license_type', ['DEMO', 'STARTER', 'ULTIMATE']);
            $table->timestamp('started_at')->default(DB::raw('NOW()'));
            $table->timestamp('expired_at');
            $table->unsignedBigInteger('max_file_size');
            $table->unsignedBigInteger('daily_object_limit');
            $table->unsignedBigInteger('quota');
            $table->string('email')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('licenses');
    }
};
