<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('activity_log', function (Blueprint $table) {
            $table->id();
            $table->string('model')->nullable();
            $table->string('action')->nullable();
            $table->text('changesData')->nullable();
            $table->text('description')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('model_id')->nullable();
            $table->string('route')->nullable();
            $table->string('ip')->nullable();
            $table->dateTime('edit_date')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');

            $table->index(['model', 'model_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
