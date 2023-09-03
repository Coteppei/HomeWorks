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
        Schema::create('user', function (Blueprint $table)
        {
            $table->id();
            $table->string('user_name', 20);
            $table->string('password');
            $table->unique('user_name');                // ユーザー名の重複対応
            // $table->rememberToken();                 // 必要に応じて実装予定
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user');
    }
};
