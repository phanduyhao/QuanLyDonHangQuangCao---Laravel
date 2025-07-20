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
         Schema::create('service_pricings', function (Blueprint $table) {
            $table->id();

            // Khóa ngoại tới bảng services
            $table->unsignedBigInteger('service_id');
            $table->foreign('service_id')->references('id')->on('services')->onDelete('cascade');

            // Tên gói giá (tuỳ chọn, ví dụ: "Gói 7 ngày", "Gói cao cấp", ...)
            $table->string('title')->nullable();

            // Mô hình tính giá
            $table->enum('pricing_model', ['cpc', 'cpm', 'package']);

            // Giá
            $table->decimal('price', 12, 2);

            // Các thông tin mở rộng (tuỳ theo loại)
            $table->integer('duration_days')->nullable();         // cho package
            $table->integer('impressions_per_day')->nullable();   // cho package
            $table->integer('clicks_per_day')->nullable();        // nếu muốn tracking cho CPC

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('service_pricings');
    }
};
