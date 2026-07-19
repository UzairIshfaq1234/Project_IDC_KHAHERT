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
        Schema::create('idc_patients', function (Blueprint $table) {
            $table->id('Id');
            $table->string('Sampleno')->unique();
            $table->string('Name');
            $table->string('Email');
            $table->string('Contactno');
            $table->string('Addedby')->nullable();
            $table->string('Doctorby')->nullable();
            $table->string('Result')->nullable();
            $table->text('Image')->nullable();
            $table->text('treated')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('idc_patients');
    }
};
