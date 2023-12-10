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
        Schema::create('orders_details', function (Blueprint $table) {
            $table->id();
            $table->integer('quantity');
            $table->decimal('amount',10,2);
            $table->unsignedBigInteger("product_id");
            $table->unsignedBigInteger("order_history_id");
            $table->foreign("product_id")->references("id")->on("products")->onDelete("cascade");
            $table->foreign("order_history_id")->references("id")->on("order_history")->onDelete("cascade");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders_details');
    }
};
