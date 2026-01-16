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
        Schema::create('submissions', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255)->comment('Tên người dùng');
            $table->text('feedback')->comment('Cảm nhận của người dùng');
            $table->string('image_path', 500)->comment('Đường dẫn ảnh đã upload');
            $table->integer('position_x')->nullable()->comment('Vị trí X ngẫu nhiên trên wall');
            $table->integer('position_y')->nullable()->comment('Vị trí Y ngẫu nhiên trên wall');
            $table->decimal('rotation', 5, 2)->default(0)->comment('Góc xoay ngẫu nhiên (độ)');
            $table->decimal('scale', 3, 2)->default(1.00)->comment('Tỷ lệ phóng to/thu nhỏ');
            $table->timestamps();
            
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('submissions');
    }
};
