<?php

use App\Enums\API_Client\Bid\BidStatusEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bids', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->foreignId('coin_id');
            $table->foreignId('currency_id');
            $table->integer('amount');
            $table->integer('price');
            $table->string('status')->default(BidStatusEnum::CREATED);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bids');
    }
};
