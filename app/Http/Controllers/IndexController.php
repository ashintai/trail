<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Player;
use App\Models\Category;
use App\Models\Park;

class IndexController extends Controller
{
/**
 * 参加者の一覧＆検索結果一覧表示のコントローラー
 * @param Request $request
 * @return Response
 * 
 */
    public function index(Request $request)
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
        if($zekken ){
            $query->where('zekken', 'LIKE' , '%'.$zekken.'%');
        }
        // 名前の検索
        if( $name ){
            $query->where('name' , 'LIKE' , '%'.$name.'%');
        }
        // 参加クラスの検索
        if ($category_id !== '0'){
            $query->where('category_id' , $category_id);
        }
        // 駐車場の検索
        if ( $park_id !== '0'){
            $query->where( 'park_id' , $park_id);
        }
        // バス券の検索
        if ($bus ){
            $query->where( 'bus' , true);
        }
        // 備考の検索
        if($comment){
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
        return view('index' , compact('data' , 'categories' , 'parks' , 'append_param'));
    }
    // 参加者詳細画面の表示
    public function edit($id)
    {
        // $id からPlayerのIDをもらい、１人のデータを拾って$oneへ代入
        $one= Player::find($id);
        return view('edit' , compact('one'));
    }

    // 全エントリーデータの読み込み
    public function csvImport(Request $request)
    {
        if ($request->hasFile('csvFile')){
            // 指定されたCSVファイル名を取得
            $file=$request->file('csvFile');
            $path=$file->getRealPath();
            // ファイルを開く
            $fp=fopen($path, 'r');
            // ヘッダ行をスキップ
            fgetcsv($fp);

            // 駐車場の割付用変数の初期化
            // $park_capa = new Park;
            // $present_park_id :現在割受け中の駐車場ID
            $present_park_id = '1';
            // $present_park_capa :現在割付中の駐車場のキャパ
            $present_park_capa = '0';
            
            // １行ずつ読込
            while(( $csvData = fgetcsv($fp)) !== FALSE){
                
                // 新しいPlayerインスタンス
                $player = new Player;
                // $player->password="1234";

                // ゼッケン番号
                $player->zekken = $csvData[43];
                
                // 名前を入れる
                $player->name=$csvData[8];
                // メールアドレスを入れる
                $player->email=$csvData[39];
                // バス券を入れる
                if ( str_contains($csvData[7] , "バス")){
                    $player->bus = '1';
                }
                // 駐車券を入れる P1から順番に満車になるまで割り付ける
                if( str_contains($csvData[7] , "駐車券付き")){
                    // 現在割付中の駐車場のキャパをDBより取得
                    $park_capa = Park::find($present_park_id);
                    if ( $present_park_capa >= $park_capa->capacity){
                        $present_park_id ++;
                        // P4で最後なので、それ以上は割り付けられない
                        if($present_park_id >= 5){ $present_park_id = 5;}
                        $present_park_capa = 0;
                    }
                    $player->park_id = $present_park_id;
                    $present_park_capa ++ ;
                }
                // 参加クラスを入れる
                // どのクラスにも当てはまらかかった場合はid=7になる
                $player->category_id = '7' ;
                if( str_contains($csvData[7] , "男子")){
                    if( str_contains($csvData[7] , "18")){
                        $player->category_id = '1';
                    }elseif( str_contains($csvData[7], "36")){
                        $player->category_id = '2';
                    }elseif( str_contains($csvData[7],"46")){
                        $player->category_id = '3';
                    }elseif( str_contains($csvData[7],"56")){
                        $player->category_id = '4';
                    }
                }elseif( str_contains($csvData[7] , "女子")){
                    if( str_contains($csvData[7] , "18")){
                        $player->category_id = '5';
                    }elseif( str_contains($csvData[7], "46")){
                        $player->category_id = '6';
                    }
                }
                // 連絡先を入れる
                $player->phone = $csvData[18] . '/' . $csvData[19] . '/' . $csvData[20] . '/' . $csvData[40];
                
                // グループ申込（メールが同じ）を入れる
                // 同じメールアドレスがすでにDBに存在した場合、最初の人のidをgroup_idへいれる
                // メールアドレスで合致する最初のレコードを検索
                $firstRecord = Player::where('email' , $csvData[39])->first();
                if ( $firstRecord ){
                    // 合致するレコードがあった場合、そのidをgroup_id へコピー
                    $player->group_id = $firstRecord->id;
                    // 最初に合致したレコードのgroup_idにも同じidを入れる
                    Player::where('id' , $firstRecord->id )->update(['group_id' => $firstRecord->id]);
                }
               
                // DBへ挿入
                $player->save();
                }
            // ファイルを閉じる        
            fclose($fp);
        }else{
            // ここにファイルがなかったときの処理
        }

        // Viewに渡すデータの準備
        // 全参加者情報
        $query = Player::query();
        $data=$query->paginate(5);
        //参加クラス全種の名前を渡す
        $categories=Category::all();
        // 駐車場の全名前を渡す
        $parks=Park::all();
        // ページネーションへ検索条件を引き継ぐ
        $append_param = ['zekken' => '' , 'name' => '' , 'category_id' => '' , 'park_id' => '' , 'bus' => '' , 'comment' => '' ];
        $data=$query->paginate(5);
        $data -> appends($append_param);

        return view('index' , compact('data' , 'categories' , 'parks' , 'append_param'));
    }

/**
 * 参加者ログイン画面
 * 
 * 
 * 
 * 
 */
public function login(){

    return view('login');
}

/**
 * グループ申込画面
 * 
 * 
 * 
 */
public function group(Request $request){

// メールアドレスからidを検索

$data = Player::where('email' , $request->email)->get();

if ( $data->isNotEmpty()){
    $one = $data->first();
    if ($one->group_id){
        // 最初のレコードにgroup_idがある場合はグループ選択画面へ
        return view('group',compact('data'));
    }else{
        // group_idがない場合は、誓約書画面へ
        return view('promise' , compact( 'one'));
    }
}else{
    // メールアドレスがない
    return back()->withInput()->withErrors(['email'=> 'メールアドレスがありません']);
}
}

public function promise(Request $request){

    $one=$request->one;
    return view('promise' , compact('one'));
}

// このあたり整理必要

// Categories　Parks　DBの初期化

public function init(Request $request){

// Categories DB の初期化

$categories = [
    "男子18～35歳",
    "男子36～45歳",
    "男子46～55歳",
    "男子56歳以上",
    "女子18～45歳",
    "女子46歳以上",
];

foreach ($categories as $category_name) {
    $cat = new Category;
    $cat->category_name = $category_name;
    $cat->save();
}

// 駐車場の初期化
$parks = [
    ["P1",30],
    ["P2",30],
    ["P3",30],
    ["P4",30],
    ["P5",30],
    ["P6",30],
];

foreach ($parks as $park) {
    $pa = new Park;
    $pa->park_name = $park[0];
    $pa->capacity = $park[1];
    $pa->save();
}


return view('index' );

}


}

