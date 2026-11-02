<?php

use App\Models\Adoption;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('adoptions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('cat_id')->constrained()->cascadeOnDelete();
            $table->string('address');
            $table->enum('housing_type', Adoption::HOUSING);
            $table->enum('experience', Adoption::EXPERIENCE);
            $table->boolean('indoor')->default(false);
            $table->boolean('cost_commitment')->default(false);
            $table->enum('status', [Adoption::PENDING, Adoption::DONE])->default(Adoption::PENDING);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('adoptions');
    }
};
