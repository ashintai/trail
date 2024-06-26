<?php

namespace App\Http\Controllers\Player;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Player;
use Illuminate\Support\Facades\Auth;

// 参加者ログイン後の最初の画面へのコントローラ
class HomeController extends Controller
{
    public function dashboard()
  {
    $player_id = Auth::guard('players')->user()->id;
    $email = Auth::guard('players')->user()->email;

    // ログインしたのが、グループ申込かどうかの判断
    // group_id は同じメールアドレスがある人はidが入る
    $group = Auth::guard('players')->user()->group_id;

    if( empty($group)){
        // group_id が空欄なので、個人申込
        // 個人申込の画面へ
        $player=Player::find($player_id);
        return view('player.home.individual',compact('player'));
    }

    // グループのメンバーリストを表示
    $member = Player::where('group_id' , $group)->get();
    return view('player.home.member',compact('member'));
  

  }

  // グループ申込のメンバー一覧画面から選ばれた一人の$id に基づき、個人情報を
  public function each($id)
  {
    $player = Player::find($id);
    return view('/player/home/individual' , compact('player'));
  }

// 誓約書へのサイン
public function promise($id)
{
  $player =Player::find($id);
  $player->promise = 1;
  $player->save();
  
  return view('/player/home/individual' , compact('player'));

}

// 駐車券の発券
public function park($id)
{
  $player = Player::find($id);
  return view('/player/home/park' , compact('player'));
}
}
