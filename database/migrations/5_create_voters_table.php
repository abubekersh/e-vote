<?php

use App\Models\address;
use App\Models\pollingStation;
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
        Schema::create('voters', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(pollingStation::class)->constrained()->onDelete('cascade')->onUpdate('cascade');
            $table->string('token');
            $table->date('date_of_birth');
            $table->enum('gender', ['male', 'female']);
            $table->string('disability');
            $table->integer('residency_duration');
            $table->foreignIdFor(address::class)->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('voters');
    }
};
