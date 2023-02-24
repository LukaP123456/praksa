<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('issues', function (Blueprint $table) {
            $table->id();
            $table->integer('redmine_id');
            $table->foreignId('project_id')->constrained()->onDelete('cascade');
            $table->integer('tracker_id');
            $table->string('tracker');
            $table->string('title');
            $table->string('description')->nullable();
            $table->integer('assignee_id')->nullable();
            $table->string('assignee')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('issues');
    }
};
