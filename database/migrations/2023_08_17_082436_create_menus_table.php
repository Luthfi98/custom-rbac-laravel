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
        Schema::create('menus', function (Blueprint $table) {
            $table->id();
            $table->foreignId('parent_id')->nullable();
            $table->string('module', 100);
            $table->string('name', 100);
            $table->string('path', 50)->default('#');
            $table->text('icon')->nullable();
            $table->tinyInteger('sort')->default(0);
            $table->enum('type', ['cms', 'landing'])->default('cms');
            $table->boolean('is_label')->default(0);

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('parent_id')->references('id')->on('menus')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menus');
    }
};
