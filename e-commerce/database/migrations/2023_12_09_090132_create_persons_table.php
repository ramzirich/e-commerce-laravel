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
        Schema::create('persons', function (Blueprint $table) {
            $table->id();
            $table->string("first_name",20);
            $table->string("last_name",20);
            $table->string("email",60)->unique();
            $table->string("password",200)->default(Hash::make("default_password"));
            $table->string("image_url", 255);
            $table->unsignedBigInteger("role_id")->default(1);
            $table->foreign("role_id")->references("id")->on("roles");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('persons');
    }
};
