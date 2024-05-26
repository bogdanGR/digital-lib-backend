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
        Schema::create('author_publication', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('publication_id');
            $table->unsignedBigInteger('person_id');
            $table->timestamps();

            $table->foreign('publication_id')->references('id')->on('publication')->onDelete('cascade');
            $table->foreign('person_id')->references('id')->on('people')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('author_publication');
    }
};
