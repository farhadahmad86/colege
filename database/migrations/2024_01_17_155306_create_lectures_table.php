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
        Schema::create('lectures', function (Blueprint $table) {
            $table->id('lec_id');
            $table->integer('lec_class_id');
            $table->integer('lec_group_id');
            $table->integer('lec_subject_id');
            $table->string('lec_title',255);
            $table->string('lec_link',500);
            $table->integer('lec_created_by');
            $table->timestamp('lec_created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lectures');
    }
};
