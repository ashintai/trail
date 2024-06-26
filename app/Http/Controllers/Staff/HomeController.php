<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Player;
use App\Models\Category;
use App\Models\Park;

  class HomeController extends Controller
  {
      public function dashboard(Request $request)
      {
          // GETで送られてくる検索条件を変数に取り出す
          $zekken = $request->zekken;
          $category_id = $request->category_id;
          $name = $request->name;
          $bus = $request->bus;
          $park_id = $request->park_id;
          $comment = $request->comment;
  
          // 検索式の生成を開始
          $query = Player::query();
  
          // ゼッケンの検索
          if( $zekken !== null ){
              $query->where('zekken', 'LIKE' , '%'.$zekken.'%');
          }
          // 名前の検索
          if( $name ){
              $query->where('name' , 'LIKE' , '%'.$name.'%');
          }
          // 参加クラスの検索
          if ($category_id !== null ){
              $query->where('category_id' , $category_id);
          }
          // 駐車場の検索
          if ( $park_id !== null ){
              $query->where( 'park_id' , $park_id);
          }
          // バス券の検索
          if ( $bus !== null ){
              $query->where( 'bus' , true);
          }
          // 備考の検索
          if( $comment ){
              $query->where( 'comment' ,'<>' , '');
          }
  
          // ページネーションへ検索条件を引き継ぐ
          $append_param = ['zekken' => $zekken , 'name' => $name , 'category_id' => $category_id , 'park_id' => $park_id , 'bus' => $bus , 'comment' => $comment ];
          $data=$query->paginate(5);
          $data -> appends($append_param);
  
          
          //参加クラス全種の名前を渡す
          $categories=Category::all();
          // 駐車場の全名前を渡す
          $parks=Park::all();
          return view('staff.home.dashboard' , compact('data' , 'categories' , 'parks' , 'append_param'));
      }
  
      // 参加者情報の詳細 ここ要修正
      public function detail($id)
      {
          // $id からPlayerのIDをもらい、１人のデータを拾って$oneへ代入
          $one= Player::find($id);
          // 参加クラスの一覧データ
          $categories = Category::all();
          // 駐車場の一覧データ
          $parks = Park::all();
  
          return view('staff.home.detail' , compact('one','categories' , 'parks'));
      }
   
      // 参加者情報の更新　ただし備考だけ ここ要修正
      public function update(Request $request)
      {
          // バリデーションルールの定義
          $rules = [
              'comment' => 'nullable|string',
              ];
                       
          //  バリデーションの実行
          $validated = $request->validate($rules );
  
          // バリデーション後の参加者情報（備考）の登録
          $player = Player::find($request->id);
          $player->comment = $validated['comment'];
          
          $player->save();
  
          return redirect( 'staff' );
  
      }
  }



