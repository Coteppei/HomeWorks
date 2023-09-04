<?php

// use Illuminate\Support\Facades\Route;

// /*
// |--------------------------------------------------------------------------
// | Web Routes
// |--------------------------------------------------------------------------
// |
// | Here is where you can register web routes for your application. These
// | routes are loaded by the RouteServiceProvider and all of them will
// | be assigned to the "web" middleware group. Make something great!
// |
// */

# ブログ一覧を表示
// 一番最初に開いた画面で表示
Route::get('/', 'App\Http\Controllers\BlogController@showList')->name('blogs');
# キーワード検索
Route::get('/search', 'App\Http\Controllers\BlogController@search')->name('search');

# 新規登録画面を表示
Route::get('/blog/create', 'App\Http\Controllers\BlogController@showCreate')->name('create');
# スレッドを新規登録
Route::post('/blog/store', 'App\Http\Controllers\BlogController@exeStore')->name('store');

# 新規アカウント登録画面表示
Route::get('/blog/signUp','App\Http\Controllers\BlogController@showSignUp')->name('signUp');

# 新規アカウント登録実行
Route::post('/blog/registration', 'App\Http\Controllers\BlogController@exeRegistration')->name('registration');

# ログイン画面表示
Route::get('/blog/login','App\Http\Controllers\BlogController@showLogin')->name('login');

# ログイン実行
Route::post('/blog/exelogin','App\Http\Controllers\BlogController@exeLogin')->name('exelogin');

# ログアウト実行
Route::get('/blog/logout','App\Http\Controllers\BlogController@Logout')->name('logout');

# 詳細画面表示
Route::get('/blog/{id}', 'App\Http\Controllers\BlogController@showDetail')->name('show');
# 回答の送信
Route::post('/blog/reply', 'App\Http\Controllers\BlogController@exeReply')->name('reply');

# 編集画面を表示
Route::get('/blog/edit/{id}', 'App\Http\Controllers\BlogController@showEdit')->name('edit');
# 編集内容に更新処理を実行
Route::post('/blog/update', 'App\Http\Controllers\BlogController@exeUpdate')->name('update');

# 投稿の削除
Route::post('/blog/delete/{id}', 'App\Http\Controllers\BlogController@exeDelete')->name('delete');
