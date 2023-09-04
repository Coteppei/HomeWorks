<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
// use Database\Factories\BlogFactory;


// 何か操作するときはblogクラスを使う。
// 継承してblogクラスを作る
// blogsテーブルの中のtitleとcontentのカラムを扱える
class Blog extends Model
{
    // テーブル名
    protected $table = 'blogs';

    // 可変項目
    // 保存したい値のこと
    protected $fillable =
    [
        'school',
        'subject',
        'login_user_id',
        'title',
        'content',
        'image_path',
    ];

    // protected static function newFactory()
    // {
    //     return BlogFactory::new();
    // }
}
