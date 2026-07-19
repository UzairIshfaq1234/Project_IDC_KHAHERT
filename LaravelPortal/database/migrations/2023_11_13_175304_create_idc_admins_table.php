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
        Schema::create('idc_admins', function (Blueprint $table) {
            $table->id('Id');
            $table->string('Name');
            $table->string('Username')->unique();
            $table->string('Email');
            $table->string('Password');
            $table->integer('Role');
            $table->string('Contactno');
            $table->text('Image');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('idc_admins');
    }
};
