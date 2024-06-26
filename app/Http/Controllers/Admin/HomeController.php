<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Player;
use App\Models\Category;
use App\Models\Park;
use App\Models\Staff;
use Barryvdh\Debugbar\Facade as Debugbar;
use Illuminate\Support\Facades\Hash;
use App\Constants;

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
        return view('admin.home.dashboard' , compact('data' , 'categories' , 'parks' , 'append_param'));
    }

    // 参加者情報の編集
    public function edit($id)
    {
        // $id からPlayerのIDをもらい、１人のデータを拾って$oneへ代入
        $one= Player::find($id);
        // 参加クラスの一覧データ
        $categories = Category::all();
        // 駐車場の一覧データ
        $parks = Park::all();

        return view('admin.home.edit' , compact('one','categories' , 'parks'));
    }
 
    // 参加者編集の更新
    public function edit_player(Request $request)
    {
        // バリデーションルールの定義
        $rules = [
            'category_id' => 'required|integer',
            'name' => 'required|string|max:255',
            'zekken' => 'required|integer',
            'email' => 'required|email',
            'park_id' => 'nullable|integer',
            'bus' => 'nullable|integer',
            'comment' => 'nullable|string',
            'dns' => 'nullable|Integer',
            'promise' => 'nullable|Integer',
            'bus_ride' => 'nullable|Integer',
            'reseption' => 'nullable|Integer',
            'phone' => 'nullable|string',
            ];
    
        //  バリデーションエラーメッセージの定義
        $messages = [
            'name.required' => '名前は必須です。',
            'category_id' => '参加クラスは必須です。',
            'email.required' => 'メールアドレスは必須です。',
            'email.email' => '有効なメールアドレスを入力してください。',
            'zekken.integer' => 'ナンバーは整数である必要があります。',
            'zekken.required' => 'ナンバーは必須です',
            ];
        
            //  バリデーションの実行
        $validated = $request->validate($rules , $messages);

        // バリデーション後の参加者の登録
        $player = Player::find($request->id);

        $player->name = $validated['name'];
        $player->category_id = $validated['category_id'];
        $player->email = $validated['email'];
        $player->zekken = $validated['zekken'];
        $player->park_id = $validated['park_id'];
        $player->bus = $validated['bus'];
        $player->dns = $validated['dns'];
        $player->comment = $validated['comment'];
        $player->promise = $validated['promise'];
        $player->bus_ride = $validated['bus_ride'];
        $player->reseption = $validated['reseption'];
        $player->phone = $validated['phone'];
        
        $player->save();

        return redirect( 'admin' );

    }

    // 新規参加者
    public function newplayer()
    {
        // 参加クラス一覧データ
        $categories = Category::all();
        // 駐車場一覧データ
        $parks = Park::all();

        return view( 'admin.home.newplayer' , compact( 'categories' , 'parks' ));
    }

    // 新規参加者登録
    public function create_newplayer(Request $request)
    {
        // バリデーションルールの定義
        $rules = [
        'category_id' => 'required|integer',
        'name' => 'required|string|max:255',
        'zekken' => 'required|integer',
        'email' => 'required|email',
        'park_id' => 'nullable|integer',
        'bus' => 'nullable|integer',
         ];

        //  バリデーションエラーメッセージの定義
        $messages = [
            'name.required' => '名前は必須です。',
            'category_id' => '参加クラスは必須です。',
            'email.required' => 'メールアドレスは必須です。',
            'email.email' => '有効なメールアドレスを入力してください。',
            'zekken.integer' => 'ナンバーは整数である必要があります。',
            'zekken.required' => 'ナンバーは必須です',
            ];

        //  バリデーションの実行
        $validated = $request->validate($rules , $messages);

        // バリデーション後の参加者の登録
        $player = new Player();

        $player->name = $validated['name'];
        $player->category_id = $validated['category_id'];
        $player->email = $validated['email'];
        $player->zekken = $validated['zekken'];
        $player->park_id = $validated['park_id'];
        $player->bus = $validated['bus'];

        $player->save();

    return redirect( 'admin' );
    }

    //
    // 初期設定
    //
    public function initial()
    {
        // 各テーブルの現在設定値を渡す
        // p_の接頭語は現在の設定値を意味する
        $p_categories = Category::all();
        $p_staffs = Staff::all();
        $p_parks = Park::all();
   
        return view( 'admin.home.initial' , compact('p_categories', 'p_staffs' , 'p_parks'));
    }
    //
    // 参加クラスの初期化 categoriesテーブル
    // id=1は常に 参加クラス未定 とする
    //
    public function ini_categories(Request $request)
    {
        // 参加クラスの設定を変数へ取り込み
        // 設定を読み込む配列
        $categories = [];

        for ($num = 1 ; $num < Constants::MAX_CATEGORY ; $num++){
            $key = "category_" . $num;
            if ( $request->$key !== null ){
                $categories[] = $request->$key;
            }
        }

        // 参加クラスがひとつもない場合の処理
        if(empty($categories)){
            return back()->withErrors([
                'ini' => ['参加クラス名の記載がありません'],
              ]);
        }

        //参加クラスの最初（id=1)は 参加クラス未定 とする
        // 配列の先頭id=1へ差し込む
        array_unshift( $categories , "参加クラス未定");

        // 参加クラステーブルの書き換え
        // 一旦categories テーブルの全レコードを消去
        Category::truncate();

        // 配列を順次create
        foreach( $categories as $category){
            $newCategory = new Category;
            $newCategory->category_name = $category;
            $newCategory->save();
        }
        return back()->withErrors([
            'ini' => ['参加クラスの設定を変更しました'],
          ]);
    }

    // 駐車場の初期設定
    public function ini_parks(Request $request)
    {
     // 設定を読み込む配列
    $parks = [];
    
    // 入力値を配列へ取り込み
    for ($num = 1 ; $num <= Constants::MAX_PARK ; $num++){
     $key_park = "park_" . $num;
     $key_capa = "capa_" . $num;
     if ( $request->$key_park !== null ){
        if( $request->$key_capa !== null ){
            $parks[] = array('name'=>$request->{$key_park} , 'capa' => $request->{$key_capa});
        }else{
            $parks[] = array('name'=>$request->{$key_park} , 'capa' => 0);
        }
     }
    }

     // 駐車場の設定がひとつもない場合の処理
     if(empty($parks)){
        return back()->withErrors([
            'ini' => ['駐車場の入力がありません'],
          ]);
    }

    // 駐車場テーブルの書き換え
    // 一旦categories テーブルの全レコードを消去
    Park::truncate();

    // 配列を順次create
    foreach( $parks as $park){
            $newPark = new Park();
            $newPark->park_name = $park['name'];
            $newPark->capacity = $park['capa']; 
            $newPark->save();
        }
    
    return back()->withErrors([
        'ini' => ['駐車場の設定を変更しました。'],
      ]);
    }

    // 全エントリーデータをCSVファイルから読み取り
    public function csvImport(Request $request)
    {
        // 読取り設定を入力より変数で受取り
        $csv_name = $request->csv_name; // 氏名の項目位置
        $csv_email = $request->csv_email; //emailの項目位置
        $csv_phone1 = $request->csv_phone1; //連絡先の項目位置その１
        $csv_phone2 = $request->csv_phone2; //              その２
        $csv_zekken = $request->csv_zekken; //ナンバーの項目位置
        $csv_category = $request->csv_category; //参加クラスの項目位置
        $csv_park = $request->csv_park; //駐車券の項目位置
        $csv_park_keyword = $request->csv_park_keyword; //駐車券のキーワード
        $csv_bus = $request->csv_bus; //バス券の項目位置
        $csv_bus_keyword = $request->csv_bus_keyword; //バス券のキーワード
               
        // CSVファイルの読み込み
        // CSV読込中の警告メッセージを初期化
        $message = "";

        // 参加者テーブルを一旦消去するか
        // チェックボックスで追加にチェックがあると$request->csv_append が送られる
        if ( !isset($request->csv_append)){
            // チェックボックスがチェックされていない場合は参加者テーブルPlayerを消去
            Player::truncate();
        }

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
            // $present_park_capa :現在割付中の駐車場の配車台数
            $present_park_capa = '0';
            
            // １行ずつCSVファイルを読込み
            while(( $csvData = fgetcsv($fp)) !== FALSE){
                
                // 新しいPlayerインスタンス
                $player = new Player();
                // ゼッケン番号
                $player->zekken = $csvData[$csv_zekken];
                // 名前
                $player->name=$csvData[$csv_name];
                // メールアドレスを入れる
                $player->email=$csvData[$csv_email];
                // バス券を入れる
                if ( str_contains($csvData[$csv_bus] , $csv_bus_keyword)){
                    $player->bus = '1';
                }
                // 駐車券を入れる P1から順番に満車になるまで割り付ける
                if( str_contains($csvData[$csv_park] , $csv_park_keyword)){
                    // 現在割付中の駐車場のキャパをDBより取得
                    $park_capa = Park::find($present_park_id);
                    if( $park_capa !== null){
                        //駐車場を$present_park_id で探して存在した場合
                        $player->park_id = $present_park_id;
                        // 駐車１台したので、$present_park_capa $pfresent_park_id を更新
                        $present_park_capa ++;
                        if ($present_park_capa >= $park_capa->capacity){
                            $present_park_id ++;
                            $present_park_capa = 0;
                        }
                    }else{
                        //駐車場を$present_park_id で探して存在しなかった場合（満車）
                        $message .= "<br>" . $csvData[$csv_name] . "さんに駐車場が割り当てられません";
                    }
                }
                // 参加クラスを入れる
                // テーブルCategories に登録されているクラス名を含むかどうかで判断
                // どのクラスにも当てはまらかかった場合はid=0になる

                $categories = Category::all();

                foreach( $categories as $category){
                    if( str_contains($csvData[$csv_category] , $category->category_name)){
                        $player->category_id = $category->id;
                    }
                }

                // 全ての参加クラス名に一致がなかった場合 id=1 参加クラス未定　とする
                if( $player->category_id === null){
                    $player->category_id = 1;
                    $message .= "<br>" . $csvData[$csv_name] . "さんの参加クラスがありません";
                }
                // 連絡先を入れる
                $player->phone = $csvData[$csv_phone1] . '/' . $csvData[$csv_phone2] ;
                
                // グループ申込（メールが同じ）を入れる
                // 同じメールアドレスがすでにDBに存在した場合、最初の人のidをgroup_idへいれる
                // メールアドレスで合致する最初のレコードを検索
                $firstRecord = Player::where('email' , $csvData[$csv_email])->first();
                if ( $firstRecord ){
                    // 合致するレコードがあった場合、そのidをgroup_id へコピー
                    $player->group_id = $firstRecord->id;
                    // 最初に合致したレコードのgroup_idにも同じidを入れる
                    Player::where('id' , $firstRecord->id )->update(['group_id' => $firstRecord->id]);
                    // メッセージに追加
                    $message .= "<br>" . $csvData[$csv_name] . "さんはグループ申込みです";
                }
               
                // DBへ挿入
                $player->save();
                }
            // ファイルを閉じる        
            fclose($fp);
        }else{
            // ここにCSVファイルがなかったときの処理
            return back()->withErrors([
                'ini' => ['CSVファイルがありません'],
              ]);
        }

        // メッセージの調整
        if ( !$message ){
            $message = "CSVファイルの読み込みは正常に終了しました";
        }

        return back()->withErrors([
            'ini' => [ $message],
          ]);

    }
    
    // スタッフアカウントの設定
    public function staffaccount(Request $request)
    {
        // 入力値を配列で受取
        $staffs = [];

        // 入力値を配列へ取り込み
        for ($num = 1 ; $num <= Constants::MAX_STAFF ; $num++){
        $key_email = "staff_email_" . $num;
        $key_pass = "staff_pass_" . $num;
        // emailとパスワード両方が入力されている場合のみ配列に加える
        if ( $request->$key_email !== null ){
           if( $request->$key_pass !== null ){
               $staffs[] = array('email'=>$request->{$key_email} , 'pass' => $request->{$key_pass});
           }
        }
       }
   
       //スタッフテーブルのクリア
        Staff::truncate();

        // 配列を順次create
        foreach( $staffs as $staff){
            $newStaff = new Staff();
            $newStaff->email = $staff['email'];
            $newStaff->password = Hash::make($staff['pass']); 
            $newStaff->save();
        }

return back()->withErrors([
'ini' => ['スタッフの設定を行いました'],
]);




    }
   
}
