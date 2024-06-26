<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
// 認証関係のファサードを使うための宣言
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
     //ログインページの表示
  public function index()
  {
    if (Auth::guard('staffs')->user()){
        return redirect()->route('staff.dashboard');
    }
    return view('staff.login.index');
  }

//ログイン処理
  public function login(Request $request)
  {
    $credentials = $request->only(['email', 'password']);

    //ユーザー情報が見つかったらログイン
\Debugbar::info(Auth::guard('staffs')->user());

    if (Auth::guard('staffs')->attempt($credentials)) {
      //ログイン後に表示するページにリダイレクト
      return redirect()->route('staff.dashboard')->with([
        'login_msg' => 'ログインしました。',
      ]);
    }

    //ログインできなかったときに元のページに戻る
    return back()->withErrors([
      'login' => ['ログインに失敗しました'],
    ]);
  }

  //ログアウト処理
  public function logout(Request $request)
  {
    Auth::guard('staffs')->logout();
    $request->session()->regenerateToken();

    //ログインページにリダイレクト
    return redirect()->route('staff.login.index')->with([
      'logout_msg' => 'ログアウトしました',
    ]);
  }
}
