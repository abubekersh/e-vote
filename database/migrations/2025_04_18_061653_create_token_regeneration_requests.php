<?php

use App\Models\voter;
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
        Schema::create('token_regeneration_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(voter::class, 'email')->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('name');
            $table->date('date_of_birth');
            $table->string('id_photo');
            $table->enum('status', ['pending', 'approved', 'rejected']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('token_regeneration_requests');
    }
};
