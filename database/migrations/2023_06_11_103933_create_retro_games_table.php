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

        Schema::create('blogs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('school');                   // 小・中・高・大の区分け
            $table->string('subject');                  // 教科
            $table->string('title', 100);               // タイトル
            $table->text('content');                    // 詳細
            $table->string('image_path')->nullable();   // 画像
            # ＊＊＊＊＊今後実装予定 ※分類が便利であるため
            // $table->string('user_id');   // ログインユーザー

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blogs');
    }
};
