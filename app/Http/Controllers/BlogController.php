<?php
namespace App\Http\Controllers;

use illuminate\Http\Request;
use App\Models\Blog;
use App\Models\Reply;
use App\Http\Requests\BlogRequest;
use App\Http\Requests\SearchRequest;
use App\Http\Requests\EditRequest;
use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\ReplyRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;


class BlogController extends Controller{
  /**
   * ブログ一覧を表示
   * ここは書かなくても問題はない。
   * ただ開発者が理解しやすくなるために書くのだ。
   * @return view
   */
    public function showList()
    {
            // ブログテーブルのデータをすべて取得する
            $blogs = Blog::all();
            if (!session()->has('id')) {
                // 'id' キーがセッション内に存在する場合の処理
                session()->put('user_name','ユーザー未登録');
            }
            // resourcesのblogディレクトリーのlistファイルに返す
            return view('blog.list', ['blogs' => $blogs]);
    }
    /**
     * ブログ詳細を表示
     * @param int $id
     * @return view
     */
    public function showDetail($id)
    {
        $foreign_id = $id;
        // ブログテーブルのidデータのみを取得する
        $blogs = Blog::find($id);
        $replies = Reply::where('foreign_id', $foreign_id)->get();
        // ブログテーブルが存在しないとき、
        if (is_null($blogs)) {
            // セッションの作成
            \Session::flash('err_msg', 'データがありません。');
            // リダイレクトでブログ一覧画面に返す。
            return redirect(route('blogs'));
        }
        return view('blog.detail', ['blogs' => $blogs, 'replies' => $replies]);
    }

    /**
     * 検索結果を表示
     * @param int $id
     * @return view
     */
    public function search(SearchRequest $request)
    {
        $keyword = $request->input('search'); // リクエストからキーワードを取得
        if ($request->has('search')) {
            $keyword .=  ' ' . $request->input('search_sub');
        }
        $keyword = mb_convert_kana($keyword, 's'); // スペースを正規化
        $keywords = preg_split('/\s+/', $keyword); // 正規表現でスペースで区切る
        $query = Blog::query();
        foreach ($keywords as $kw) {
            $query->where(function ($query) use ($kw) {
                $query->where('title', 'LIKE', '%' . $kw . '%')
                    ->orWhere('content', 'LIKE', '%' . $kw . '%')
                    ->orWhere('school', $kw)
                    ->orWhere('subject', $kw);
            });
        }
        $blogs = $query->get();
        return view('blog.list', ['blogs' => $blogs]);
    }

    /**
     * 対象掲示板に返信
     * @param int $id
     */
    public function exeReply(ReplyRequest $request)
    {
        $inputs = $request->all();
        \DB::beginTransaction();
        try {
            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('image', 'public');
                $inputs['image_path'] = $imagePath;
            }
            Reply::create($inputs);
            \DB::commit();
        } catch(\Throwable $e) {
            \DB::rollback();
            abort(500);
        }
        \Session::flash('err_msg', '対象の質問に回答しました');
        return redirect(route('blogs'));
    }

    /**
     * ブログ登録画面を表示する
     * @return view
     */
    public function showCreate()
    {
        return view('blog.form');
    }

    /**
     * ブログ登録する
     * @return view
     */
    public function exeStore(BlogRequest $request)
    {
        $inputs = $request->all();
        \DB::beginTransaction();
        try {
            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('image', 'public');
                $inputs['image_path'] = $imagePath;
            }
            $inputs['login_user_id'] = session()->get('id');
            // ブログを登録
            Blog::create($inputs);
            \DB::commit();
        } catch(\Throwable $e) {
            \DB::rollback();
            abort(500);
        }
        \Session::flash('err_msg', 'ブログを登録しました');
        return redirect(route('blogs'));
    }

    /**
     * 新規アカウント登録画面を表示
     * @param int $id
     * @return view
     */
    public function showSignUp(){
        return view('blog.signUp');
    }

    /**
     * 新規アカウントを登録
     * @param int $id
     * @return view
     */
    public function exeRegistration(CreateUserRequest $request){
    $inputs = $request->all();
    // パスワードをハッシュ化
    $inputs['password'] = Hash::make($inputs['password']);
    \DB::beginTransaction();
    try {
        $user = User::Create($inputs);
        session()->put('id',$user->id);
        session()->put('user_name','ログインユーザー： ' . $user->user_name . 'さん');
        \DB::commit();
    } catch(\Throwable $e) {
        \DB::rollback();
        \Session::flash('err_msg', 'すでに同名のユーザーが存在します。');
        \Session::flash('err_msg_next', '別のユーザー名で登録してください。🙇');
        return redirect(route('signUp'));
    }
    \Session::flash('err_msg', 'ユーザー登録しました。こんにちは' . $user->user_name . 'さん');
    return redirect(route('blogs'));
    }

    /**
     * 既存アカウントログイン画面を表示
     * @param int $id
     * @return view
     */
    public function showlogin(){
        return view('blog.login');
    }
    /**
     * ログイン機能
     * @param int $id
     */
    public function exelogin(LoginRequest $request){
        // ユーザー名とパスワードを取得
            $user_name = $request->input('user_name');
            $password = $request->input('password');
        // ユーザー名を取得
        $user = User::where('user_name', $user_name)->first();
        if ($user && password_verify($password, $user->password)) {
            session()->put('id',$user->id);
            session()->put('user_name','ログインユーザー： ' . $user->user_name . 'さん');
            return redirect(route('blogs'));
        } else {
            \Session::flash('err_msg', 'ログインに失敗しました。');
            \Session::flash('err_msg_next', 'もう一度、ご確認の上各情報を入力ください。🙇');
            return redirect(route('login'));
        }
    }

    /**
     * ログアウトする
     * @param int $id
     * @return view
     */
    public function logout(){
        Session::flush();
        return redirect('/');
    }

    /**
     * ブログ編集を表示
     * @param int $id
     * @return view
     */
    public function showEdit($id)
    {
            // ブログテーブルのidデータのみを取得する
            $blogs = Blog::find($id);
            // ブログテーブルが存在しないとき、
            if (is_null($blogs)) {
                // セッションの作成
                \Session::flash('err_msg', 'データがありません。');
                // リダイレクトでブログ一覧画面に返す。
                return redirect(route('blogs'));
            }
            return view('blog.edit', ['blogs' => $blogs]);
    }

    /**
     * ブログ更新する
     * @return view
     */
    public function exeUpdate(EditRequest $request)
    {
        $inputs = $request->all();
        \DB::beginTransaction();
        try {
            // ブログを更新
            $blogs = Blog::find($inputs['id']);
            $blogs->fill([
                'title' => $inputs['title'],
                'content' => $inputs['content'],
            ]);
            $blogs->save();
            \DB::commit();
        } catch(\Throwable $e) {
            \DB::rollback();
            abort(500);
        }
        \Session::flash('err_msg', 'ブログを更新しました');
        return redirect(route('blogs'));
    }

    /**
     * ブログ削除
     * @param int $id
     * @return view
     */
    public function exeDelete($id)
    {
        if (empty($id)) {
            \Session::flash('err_msg', 'データがありません。');
            return redirect(route('blogs'));
        }
        try {
            // ブログを削除
            Blog::destroy($id);
        } catch(\Throwable $e) {
            abort(500);
        }
                \Session::flash('err_msg', '削除しました。');
                // リダイレクトでブログ一覧画面に返す。
                return redirect(route('blogs'));
    }
}
