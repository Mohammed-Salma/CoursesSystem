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
        Schema::create('training_courses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('courseID')->references('id')->on('courses')->onUpdate('cascade');
            $table->date('start_date')->comment('The date when the training course starts');
            $table->date('end_date')->comment('The date when the training course ends');
            $table->decimal('price', 8, 2)->comment('The price of the training course');
            $table->string('note')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('training_courses');
    }
};
