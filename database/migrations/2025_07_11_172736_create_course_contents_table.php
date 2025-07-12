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
        Schema::create('course_contents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')
                ->constrained('courses')
                ->onDelete('cascade');
            // عنوان الدرس ثنائي اللغة
            $table->string('title_ar');
            $table->string('title_en');
            // نصّ الدرس ثنائي اللغة
            $table->longText('content_ar');
            $table->longText('content_en');
            // رابط فيديو اختياري (مثلاً للدرس الواحد)
            $table->string('video_url')->nullable();
            // لترتيب الدروس داخل الدورة
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('course_contents');
    }
};
