<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('groups', function (Blueprint $table) {
            $table->id();
            $table->string('name', 30);
            //$table->timestamps();
        });

        Schema::create('competitors', function (Blueprint $table) {
            $table->id();
            $table->string('name', 60);
            $table->bigInteger('group_id')->unsigned()->nullable();
            $table->integer('starting_number')->unique();
            $table->timestamps();

            $table->foreign('group_id')->references('id')->on('groups')->onDelete('set null');

        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('competitors', function (Blueprint $table) {
            Schema::dropIfExists('competitors');
            Schema::dropIfExists('groups');
        });
    }
};
