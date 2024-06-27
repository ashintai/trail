<?php

namespace App\Http\Controllers\Player;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\Debugbar\Facade as Debugbar;
use App\Utils\NumberGenerator;
use App\Models\Player;
use Illuminate\Support\Facades\Hash;
use App\Mail\PassEmail;
use Illuminate\Support\Facades\Mail;

class LoginController extends Controller
{
    //ログインページの表示
  public function index()
  {
    if (Auth::guard('players')->user()){
        return redirect()->route('player.dashboard');
    }

    return view('player.login.index');
  }

    //ログイン処理
  public function login(Request $request)
  {
  
    $email = $request->email;
    $password = $request->password;

    // パスコードのみ空欄で「ログイン」がクリックされた場合→パスコードの発行
    if (empty($password ) && !empty($email)){
        
        // emailが存在するか確認
        $player = Player::where('email' , $email)->first();

        if($player){
            // emailが存在する場合
            // 4桁パスコード発行
            $passcode = $this->generateRandomNumber();
            // テーブルに書き込む
            $player->password = Hash::make($passcode);
            $player->save(); 
            // メール送信処理
            // APP_LEVEL=TESTの時は送信せず、メッセージで伝える
            $appLevel = config('app.app_level');
            if ($appLevel === 'TEST'){
                return back()->withErrors([
                    'login' => ['テストモード：パスコードを発行しました'. $passcode . $request->email ],
                  ]);
            }else{
                // 本人にパスコードをメールで送信
                // 本番ではこう修正
                // Mail::to( $email )->send(new PassEmail($passcode ));
                return back()->withErrors([
                    'login' => ['本番モード：パスコードを発行しました' . $passcode],
                  ])->withInput();
            }
          
        }else{
            // emailが存在しない
            return back()->withErrors([
                'login' => ['メールアドレス登録されていません'],
              ])->withInput();
        }
    }
    
    // メールアドレスとパスコードが両方入力されている、または両方空欄
    // ログイン処理を行う

    $credentials = $request->only(['email', 'password']);

    //ユーザー情報が見つかったらログイン
    if (Auth::guard('players')->attempt($credentials)) {
      //ログイン後に表示するページにリダイレクト
      return redirect()->route('player.dashboard')->with([
        'login_msg' => 'ログインしました。',
      ]);
    }

    //ログインできなかったときに元のページに戻る
    return back()->withErrors([
      'login' => ['ログインに失敗しました'],
    ])->withInput();
  }

  //ログアウト処理
  public function logout(Request $request)
  {
    Auth::guard('players')->logout();
    $request->session()->regenerateToken();

    //ログインページにリダイレクト
    return redirect()->route('player.login.index')->with([
      'logout_msg' => 'ログアウトしました',
    ]);
  } 


// 乱数で４桁のパスコードを生成
public function generateRandomNumber()
{
    $randomNumber = random_int(1000, 9999);
    return $randomNumber;
}

}
