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
        Schema::create('permohonans', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('instanses_id')->unsigned();
            $table->bigInteger('category_id')->unsigned();
            // $table->Category_id();
            $table->string('name');
            $table->string('deskripsi');
            $table->bigInteger('status_id')->unsigned();
            // $table->Status_id();
            $table->timestamps();

            $table->foreign('instanses_id')->references('id')->on('instanses')->onDelete('cascade');
            $table->foreign('status_id')->references('id')->on('statuses')->onDelete('cascade');
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('permohonans');

    }
};
