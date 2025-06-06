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
        Schema::create('election_timelines', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['party registration', 'candidate registration', 'voter registration', 'election day']);
            $table->dateTime('starts');
            $table->dateTime('ends');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('election_timelines');
    }
};
