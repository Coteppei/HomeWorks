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
use App\Http\Controllers\BlogController;

# ブログ一覧を表示
# 一番最初に開いた画面で表示
Route::get('/', [BlogController::class, 'showList'])->name('blogs');
# キーワード検索
Route::get('/search', [BlogController::class, 'search'])->name('search');
# ログインユーザーが宿題を投稿した記事のみ表示
Route::get('/userSearch', [BlogController::class, 'userSearch'])->name('userSearch');
# 全ユーザーが宿題を投稿した記事を表示
Route::get('/allSearch', [BlogController::class, 'allSearch'])->name('allSearch');

# /blogから始まるURLをグループ化
Route::prefix('blog')->group(function () {
    # 新規宿題登録画面を表示
    Route::get('/create', [BlogController::class, 'showCreate'])->name('create');
    # スレッドを新規登録
    Route::post('/store', [BlogController::class, 'exeStore'])->name('store');

    # 新規アカウント登録画面表示
    Route::get('/signUp', [BlogController::class, 'showSignUp'])->name('signUp');
    # 新規アカウント登録実行
    Route::post('/registration', [BlogController::class, 'exeRegistration'])->name('registration');

    # ログイン画面表示
    Route::get('/login', [BlogController::class, 'showLogin'])->name('login');
    # ログイン実行
    Route::post('/exelogin', [BlogController::class, 'exeLogin'])->name('exelogin');
    # ログアウト実行
    Route::get('/logout', [BlogController::class, 'Logout'])->name('logout');

    # 宿題詳細画面表示
    Route::get('/{id}', [BlogController::class, 'showDetail'])->name('show');
    # 回答の送信
    Route::post('/reply', [BlogController::class, 'exeReply'])->name('reply');
    # 問題解決したことを反映
    Route::post('/resolve', [BlogController::class, 'exeResolve'])->name('resolve');
    # 編集画面を表示
    Route::get('/edit/{id}', [BlogController::class, 'showEdit'])->name('edit');
    # 編集内容に更新処理を実行
    Route::post('/update', [BlogController::class, 'exeUpdate'])->name('update');
    # 投稿した宿題の削除
    Route::post('/delete/{id}', [BlogController::class, 'exeDelete'])->name('delete');
});
