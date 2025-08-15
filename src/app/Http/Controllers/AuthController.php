<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\AuthRequest;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    ##ユーザー登録
    public function create(AuthRequest $request)
    {
        $form = $request->all();
        User::create($form);
        return redirect('/login');
    }

    ##ログイン
    public function login(LoginRequest $request)
    {
        // フォームから email と password を取得
        $email = $request->input('email');
        $password = $request->input('password');

        // Usersテーブルから一致するユーザーを取得
        $user = User::where('email', $email)
            ->where('password', $password)
            ->first();

        if ($user) {
            // ログイン成功: セッションにユーザー情報を保存
            Session::put('user_id', $user->id);
            Session::put('user_email', $user->email);

            return redirect('/admin'); // 管理画面へ
        }
    }

    ##ログアウト
    public function logout(Request $request)
    {
        // セッション情報を削除
        Session::forget('user_id');
        Session::forget('user_email');

        return redirect('/login'); // ログイン画面にリダイレクト
    }
}
