<?php
namespace App\Http\Controllers;

use illuminate\Http\Request;
use App\Models\Blog;
use App\Models\Reply;
use App\Http\Requests\BlogRequest;
use App\Http\Requests\EditRequest;
use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\ReplyRequest;
use App\Models\User;
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
     * 対象掲示板に返信
     * @param int $id]
     */
    public function exeReply(ReplyRequest $request)
    {
        //
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
     * 新規アカウント登録画面を表示
     * @param int $id
     * @return view
     */
    public function exeRegistration(CreateUserRequest $request){
        $inputs = $request->all();
        \DB::beginTransaction();
        try {
            $user = User::Create($inputs);
            \DB::commit();
        } catch(\Throwable $e) {
            \DB::rollback();
            abort(500);
        }
        \Session::flash('err_msg', 'ユーザー登録しました。こんにちは' . $user->user_name . 'さん');
        return redirect(route('blogs'));
    }

        // $data = $request->validated(); // バリデーションを通過したデータを取得

        // ユーザーをデータベースに登録
        // User::create([
        //     'user_name' => $data['user_name'],
        //     'password' => $data['password'],
        // ]);

        // // 登録完了メッセージなどをセッションに設定
        // \Session::flash('success_msg', 'アカウントを登録しました');

        // 登録後にどの画面にリダイレクトするかを設定


    /**
     * 既存アカウントログイン画面を表示
     * @param int $id
     * @return view
     */
    public function showlogin(){
        return view('blog.login');
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
