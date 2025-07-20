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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_code')->unique();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('service_pricing_id');
            $table->string('campaign_name')->nullable();
            $table->text('campaign_content');
            $table->date('start_date');
            $table->date('end_date');
            $table->unsignedInteger('number_of_days');
            $table->decimal('total_amount', 15, 2);
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->text('rejection_reason')->nullable();
            $table->timestamps();

            // Foreign key constraints (nếu muốn thêm)
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('service_pricing_id')->references('id')->on('service_pricings')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order');
    }
};
