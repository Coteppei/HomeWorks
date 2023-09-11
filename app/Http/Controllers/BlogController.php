<?php
namespace App\Http\Controllers;

use illuminate\Http\Request;
use App\Models\Blog;
use App\Models\Reply;
use App\Http\Requests\ResolveRequest;
use App\Http\Requests\BlogRequest;
use App\Http\Requests\SearchRequest;
use App\Http\Requests\EditRequest;
use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\ReplyRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;


class BlogController extends Controller{
  /**
   * 宿題一覧を表示
   * ここは書かなくても問題はない。
   * ただ開発者が理解しやすくなるために書くのだ。
   * @return view
   */
    public function showList()
    {
        // 未ログイン確認
        if (!session()->has('id')) {
            session()->put('user_name', 'ユーザー未登録');
        }
        $blogs = DB::table('blogs')
        ->orderBy('created_at', 'desc');
        // 自分の宿題を表示が適応している時はその状態で表示
        // どちらの条件でもページングで表示
        if (session()->has('user_search_flg')) {
            $blogs ->where('login_user_id', session('id'));
        }
        $blogs = $blogs->simplePaginate(10);
        return view('blog.list', ['blogs' => $blogs]);
    }
    /**
     * 宿題の詳細を表示
     * @param int $id
     * @return view
     */
    public function showDetail($id)
    {
        $blogs = Blog::find($id);
        $replies = Reply::where('foreign_id', $id)->get();
        if (is_null($blogs)) {
            // セッションの作成
            \Session::flash('err_msg', 'データがありません。');
            return redirect(route('blogs'));
        }
        return view('blog.detail', ['blogs' => $blogs, 'replies' => $replies]);
    }

    /**
     * 宿題が解決したと判断する処理
     * @param int $id
     */
    public function exeResolve(ResolveRequest $request)
    {
        $inputs = $request->all();
        \DB::beginTransaction();
        try {
            $blogs = Blog::find($inputs['id']);
            $blogs->resolve_judgement = 1;
            $blogs->save(); // ブログモデルを保存して更新を反映
            \DB::commit();
        } catch (\Throwable $e) {
            \DB::rollback();
            abort(500);
        }
        \Session::flash('err_msg', 'あなたの宿題が一つ終わりました！やったね🎊😆🎉');
        return redirect(route('blogs'));
    }

    /**
     * 自分の宿題のみを表示
     * @param int $id
     * @return view
     */
    public function userSearch()
    {
        if(session('user_name') === 'ユーザー未登録') {
            $blogs = DB::table('blogs')->orderBy('created_at', 'desc')->simplepaginate(10);
        } else {
            session()->put('user_search_flg', '1');
            $blogs = DB::table('blogs')
            ->where('login_user_id', session('id'))
            ->orderBy('created_at', 'desc')
            ->simplePaginate(10);
        }
        return view('blog.list', ['blogs' => $blogs]);
    }

    /**
     * 全ユーザーの宿題を表示
     * @param int $id
     * @return view
     */
    public function allSearch()
    {
        // 自分の宿題のみ表示の場合、全ユーザーの宿題が表示できるようにする
        if (session()->has('user_search_flg')) {
            session()->forget('user_search_flg');
        }
        $blogs = DB::table('blogs')->orderBy('created_at', 'desc')->simplepaginate(10);
        return view('blog.list', ['blogs' => $blogs]);
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
            $keyword .= ' ' . $request->input('search_sub');
            if ($request->input('search_judge') !== '選択しない') {
                $keyword .= ' ' . $request->input('search_judge');
            }
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
                // "解決済" のキーワードが含まれている場合、resolve_judgement = 1 のデータも検索
                if (strpos($kw, '解決済') !== false) {
                    $query->orWhere('resolve_judgement', 1);
                } elseif (strpos($kw, '未解決') !== false) {
                    $query->orWhere('resolve_judgement', 0);
                }
            });
        }
        // 自分の宿題を表示が適応している時はその状態で検索
        if (session()->has('user_search_flg')) {
            $blogs = $query->where('login_user_id', session('id'))
                ->orderBy('created_at', 'desc')
                ->simplepaginate(10);
        } else {
            $blogs = $query
                ->orderBy('created_at', 'desc')
                ->simplepaginate(10);
        }
        // 宿題と検索キーワードをページネーション用に取得
        return view('blog.list', ['blogs' => $blogs, 'keyword' => $keyword]);
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
     * 新規宿題登録画面を表示する
     * @return view
     */
    public function showCreate()
    {
        return view('blog.form');
    }

    /**
     * 新規宿題を登録する
     * @return view
     */
    public function exeStore(BlogRequest $request)
    {
        $inputs = $request->all();
        \DB::beginTransaction();
        try {
            // 画像データがある場合
            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('image', 'public');
                $inputs['image_path'] = $imagePath;
            }
            // ログインユーザーである場合のみ登録
            if (session()->get('id')) {
                $inputs['login_user_id'] = session()->get('id');
            } else {
                \Session::flash('err_msg', 'ログインが無効です。ログインしてください');
                return redirect(route('blogs'));
            }

            // ブログを登録
            Blog::create($inputs);
            \DB::commit();
        } catch(\Throwable $e) {
            \DB::rollback();
            abort(500);
        }
        \Session::flash('err_msg', 'ブログを登録しました');
        if (session()->has('user_search_flg')) {
            return redirect(route('userSearch'));
        } else {
            return redirect(route('blogs'));
        }
    }

    /**
     * 新規アカウント登録画面を表示
     * @param int $id
     * @return view
     */
    public function showSignUp()
    {
        return view('blog.signUp');
    }

    /**
     * 新規アカウントを登録
     * @param int $id
     * @return view
     */
    public function exeRegistration(CreateUserRequest $request)
    {
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
    public function showlogin()
    {
        return view('blog.login');
    }
    /**
     * ログイン機能
     * @param int $id
     */
    public function exelogin(LoginRequest $request)
    {
            // ユーザー名とパスワードを取得
            $user_name = $request->input('user_name');
            $password = $request->input('password');
        // ユーザー名を取得
        $user = User::where('user_name', $user_name)->first();
        if ($user && password_verify($password, $user->password)) {
            session()->put('id',$user->id);
            session()->put('user_name','ログインユーザー： ' . $user->user_name . 'さん');
            \Session::flash('err_msg', 'ログインに成功しました。こんにちは' . $user->user_name . 'さん');
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
    public function logout()
    {
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
            \Session::flash('previousUrl', url()->previous());
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
            $blog = Blog::find($inputs['id']);
            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('image', 'public');
                $inputs['image_path'] = $imagePath;
                $blog->fill([
                    'school' => $inputs['school'],
                    'subject' => $inputs['subject'],
                    'title' => $inputs['title'],
                    'content' => $inputs['content'],
                    // 画像がある場合は更新
                    'image_path' => $inputs['image_path'],
                ]);
            } else {
                $blog->fill([
                    'school' => $inputs['school'],
                    'subject' => $inputs['subject'],
                    'title' => $inputs['title'],
                    'content' => $inputs['content'],
                ]);
            }
            $blog->save();
            \DB::commit();
        } catch(\Throwable $e) {
            \DB::rollback();
            abort(500);
        }
        \Session::flash('success_msg', '宿題内容を更新しました');
        return redirect(session('previousUrl'));
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
            // 投稿と返答の両方を削除
            Blog::destroy($id);
            reply::where('foreign_id', $id)->delete();
        } catch(\Throwable $e) {
            abort(500);
        }
                \Session::flash('err_msg', '削除しました。');
                // リダイレクトでブログ一覧画面に返す。
                return redirect(route('blogs'));
    }
}
