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
        Schema::create('file', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('file_path');
            $table->integer('size');
            $table->string('type');
            $table->timestamps();
        });

        Schema::create('course', function (Blueprint $table) {
            $table->id();
            $table->string('title_en');
            $table->string('title_gr');
            $table->integer('type')->comment('Undergraduate / Graduate');
            $table->timestamps();
        });

        Schema::create('people', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('role')->comment('Faculty, Researchers');
            $table->string('title')->comment('Assistant professor etc..');
            $table->timestamps();
        });

        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('project_name');
            $table->string('framework');
            $table->string('contract_number');
            $table->integer('status');
            $table->integer('type')->comment('EU / GR');
            $table->text('full_title');
            $table->text('participants');
            $table->double('budget');
            $table->text('description');
            $table->string('project_url');
            $table->date('date_start');
            $table->date('date_end');
            $table->timestamps();
        });

        Schema::create('publication', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->bigInteger('author_id')->unsigned();
            $table->text('abstract');
            $table->text('publisher');
            $table->date('publication_date');
            $table->string('file');
            $table->integer('publication_type');
            $table->bigInteger('file_id')->unsigned();
            $table->timestamps();

            $table->foreign('author_id')->references('id')->on('people');
            $table->foreign('file_id')->references('id')->on('file');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('file');
        Schema::dropIfExists('course');
        Schema::dropIfExists('people');
        Schema::dropIfExists('projects');
        Schema::dropIfExists('publications');
    }
};
