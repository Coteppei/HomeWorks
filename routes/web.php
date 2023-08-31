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
# -> で名前が付けれる
// Route::get('/','BlogController@showList')->name('blogs');

#ただハローワールドを表示させるためのプログラム

// use App\Http\Controllers\HelloWorldController;

// Route::get('/', [HelloWorldController::class, 'index']);


# ブログ一覧を表示
// 一番最初に開いた画面で表示
Route::get('/', 'App\Http\Controllers\BlogController@showList')->name('blogs');

# 新規登録画面を表示
Route::get('/blog/create', 'App\Http\Controllers\BlogController@showCreate')->name('create');
# スレッドを新規登録
Route::post('/blog/store', 'App\Http\Controllers\BlogController@exeStore')->name('store');

# 新規アカウント登録画面表示
Route::get('/blog/signUp','App\Http\Controllers\BlogController@showSignUp')->name('signUp');

# 新規アカウント登録
// 改修中20230809
Route::post('/blog/registration', 'App\Http\Controllers\BlogController@exeRegistration')->name('registration');

# 既存アカウントログイン
Route::get('/blog/login','App\Http\Controllers\BlogController@showLogin')->name('login');

# ログアウト
Route::get('/blog/logout','App\Http\Controllers\BlogController@Logout')->name('logout');

# 詳細画面を表示
Route::get('/blog/{id}', 'App\Http\Controllers\BlogController@showDetail')->name('show');
# ブログに回答
Route::post('/blog/reply', 'App\Http\Controllers\BlogController@exeReply')->name('reply');

# 編集画面を表示
Route::get('/blog/edit/{id}', 'App\Http\Controllers\BlogController@showEdit')->name('edit');
# ブログを編集
Route::post('/blog/update', 'App\Http\Controllers\BlogController@exeUpdate')->name('update');

# ブログ削除
Route::post('/blog/delete/{id}', 'App\Http\Controllers\BlogController@exeDelete')->name('delete');









