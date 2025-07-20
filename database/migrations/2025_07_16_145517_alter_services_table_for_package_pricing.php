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
        Schema::table('services', function (Blueprint $table) {
            // Xóa các cột cũ
            $table->dropColumn(['price', 'unit']);

            // Thêm các cột mới cho gói quảng cáo
            $table->decimal('package_price', 15, 2)->nullable(); // Giá của toàn bộ gói
            $table->integer('package_duration_days')->nullable();   // Thời gian chạy của gói (tính bằng ngày)
            $table->integer('impressions_per_day')->nullable();     // Số lượt tiếp cận ước tính mỗi ngày
            $table->string('pricing_model');                     // Ví dụ: 'package', 'cpc', 'cpm'
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('services', function (Blueprint $table) {
            // Thêm lại các cột cũ
            $table->decimal('price', 15, 2);
            $table->string('unit');

            // Xóa các cột mới
            $table->dropColumn(['package_price', 'package_duration_days', 'impressions_per_day', 'pricing_model']);
        });
    }
};