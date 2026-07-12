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
        Schema::create('applications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('requirement_id')
                ->constrained()
                ->cascadeOnDelete();
             $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->text('message');

            $table->decimal('quoted_price', 10, 2);

            $table->unsignedInteger('estimated_days');

            $table->enum('status', [
                'pending',
                'accepted',
                'rejected',
                'cancelled'
            ])->default('pending');
            
            $table->timestamps();

            $table->unique([
                'requirement_id',
                'user_id'
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('applications');
    }
};
