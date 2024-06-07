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
        Schema::create('files', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->unsignedBigInteger('user_id');
            $table->string('bucket');
            $table->string('key');
            $table->string('object_url');
            // It can be stream upload and doesn't have any filename. It's still downloadable with the key information.
            $table->string('filename')->nullable();
            $table->text('description')->nullable();
            $table->boolean('is_public')->default(false);
            $table->string('checksum')->nullable();
            $table->timestamp('expired_at')->nullable();
            $table->string('mimetype')->nullable();
            $table->unsignedBigInteger('size')->nullable();
            $table->json('metadata')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('files');
    }
};
