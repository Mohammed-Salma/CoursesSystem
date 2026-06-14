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
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255);
            $table->string('phone', 100);
            $table->string('address', 255);
            $table->string('image', 255);
            $table->string('nationalID', 30);
            $table->string('note', 255);
            $table->foreignId('country_id')->references('id')->on('countries')->onUpdate('cascade');
            $table->tinyInteger('active')->default(1)->comment('هل الطالب نشط أم لا');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
