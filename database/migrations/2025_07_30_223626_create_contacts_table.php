<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('contacts', function (Blueprint $table) {
            $table->id();
            $table->string('name');                       // Họ tên người gửi
            $table->string('email');                      // Email liên hệ
            $table->string('phone')->nullable();          // Số điện thoại
            $table->text('message');                      // Nội dung liên hệ
            $table->timestamps();                         // created_at & updated_at
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('contacts');
    }
};
