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
        Schema::table('token_regeneration_requests', function (Blueprint $table) {
            $table->dropForeign(['email']);
            $table->dropColumn(['email']);
            $table->foreignIdFor(voter::class)->constrained()->cascadeOnDelete()->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('token_regenerateion_requests', function (Blueprint $table) {
            //
        });
    }
};
