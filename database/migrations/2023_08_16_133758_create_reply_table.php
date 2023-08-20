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
        Schema::create('reply', function (Blueprint $table) {
            // 回答内容と写真添付のみ実装
            $table->id();
            $table->integer('foreign_id');             // blogsテーブルのIDと紐づけるID
            $table->text('content');                    // 回答内容
            $table->string('image_path')->nullable();   // 画像
            $table->timestamps();
            # ＊＊＊＊＊ユーザーごとに紐づけできるような仕組みを実装予定
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reply');
    }
};
