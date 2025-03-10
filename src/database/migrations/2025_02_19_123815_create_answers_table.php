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
        Schema::create('answers', function (Blueprint $table) {
            $table->id();

            $table->text('answer');
            $table->integer('rate');
            $table->integer('user_id')->constrained('users', 'id')->onDelete('cascade');
            $table->integer('question_id')->constrained('questions', 'id')->onDelete('cascade');
            $table->integer('interview_result_id')->constrained('interview_results', 'id')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('answers');
    }
};
