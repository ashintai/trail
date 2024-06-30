<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Bootstrap5導入 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="UTF-8">
    <title>三河高原トレラン＞管理者</title>

</head>
<body>
<header>
    <h5 class="m-2">三河高原トレイルランニングレース　大会運営支援システム</h5>
    <hr>
</header> 

<!-- 戻るボタン -->
<div class="text-end">
    <a href=" {{ url('admin/') }}" class="btn btn-primary m-1">戻る</a>
</div>

<!-- 初期化エラーおよびメッセージの表示 -->
@error('ini')
    <p class="text-danger ms-3" >{!! $message !!}</p>
@enderror
   
<!-- 参加クラス名の設定 -->
<div class="ms-3" ><h6>参加クラス名の設定</h6></div>

<div class="ms-3">
    参加クラス名は必ず全角空白も含めCSVファイルに記憶された通りに入力してください。<br>
    参加クラスに該当がない場合、「参加クラス未定」が設定されます。<br>
</div>

<form action="{{ url('admin/ini_categories') }}" method="POST">
@csrf
    <!-- 始めは現在のp_categoriesの内容を表示 -->
    <!-- $num は何行目を示す。１で初期化 -->
    @php
        $num = 1
    @endphp
    <!-- 現在設定されている参加クラステーブル内容を$p_categoriesから順次拾って表示 -->
    @foreach ($p_categories as $category)
        <!-- id=1は常に参加クラスなしに設定されるため、除外する -->
        @if( $num !== 1)
            <div class="d-flex m-1">
                <label class="w-25 text-end">{{ $num-1 }}:</label>
                <input type="text" name ="category_{{ $num-1 }}"  class="w-25 border border-dark rounded-1 bg-info text-end " value="{{ $category->category_name }}">
            </div>
        @endif
        @php
            $num++
        @endphp
    @endforeach

    <!-- 残りは空欄の参加クラスで埋める　最大はMAX＿CAtegory-->
    @for( ; $num <= \App\Constants::MAX_CATEGORY ; $num++)
        <div class="d-flex m-1">
            <label class="w-25 text-end">{{ $num-1 }}:</label>
            <input type="text" name ="category_{{ $num-1 }}" class=" w-25 border border-dark rounded-1 bg-info text-end " >
        </div>
    @endfor
    <!-- 参加クラスの設定ボタン -->
    <div class="w-50">
        <div class="text-end">   
            <button class="btn btn-primary">参加クラスの設定</button>
        </div>
    </div>
</form>
   
<br>

<div class="ms-3" ><h6>駐車場の設定</h6></div>

<div class="ms-3">
    駐車場の名称および駐車可能台数を設定してください。<br>
    CSVファイルの上から順番に駐車場が割り当てられます。<br>
    注）駐車場名称は２文字を超えると駐車券で表示がはみ出ます。<br>
</div>

<form action=" {{ url('admin/ini_parks') }}" method="POST">
    @csrf
    
    <!-- 駐車場Numの初期化 -->
    @php
        $num = 1
    @endphp
    
    <!--駐車場設定タイトル -->
    <div class=" d-flex m-1">
        <label class = " w-20 text-end">　</label>
        <label class = " w-25 text-end">駐車場名称</label>  
        <label class= " w-25 text-end">駐車台数</label>        
    </div>
    <!-- 始めは現在の設定値を表示 -->
    @foreach($p_parks as $park)
        <div class=" d-flex m-1" >
            <label class = "ms-3  w-20 text-end">{{ $num }}:</label>
            <input type="text" name ="park_{{ $num }}"  class="  w-25 border border-dark rounded-1 bg-info text-end " value="{{ $park->park_name }}">
            <input type="text" name = "capa_{{ $num }}" class="  w-25 border border-dark rounded-1 bg-info text-end " value="{{ $park->capacity }}">
        </div>
        @php
            $num ++ ;
        @endphp
    @endforeach
    <!-- 残りを空欄で埋める　最大はMAX_PARK -->
    @for( ; $num <= \App\Constants::MAX_PARK ; $num++)
        <div class=" d-flex m-1" >
            <label class = "ms-3  w-20 text-end">{{ $num }}:</label>
            <input type="text" name ="park_{{ $num }}"  class="  w-25 border border-dark rounded-1 bg-info text-end " >
            <input type="text" name = "capa_{{ $num }}" class="  w-25 border border-dark rounded-1 bg-info text-end " >
        </div>
    @endfor

    <!-- 駐車場の設定ボタン -->
    <div class=" w-50">
        <div class="text-end" >
            <button class="btn btn-primary">駐車場の設定</button>
        </div>
    </div>
</form>

<br>

<!-- CSVファイルからのデータの取り込み -->

<div class="ms-3" ><h6>エントリーデータのCSVファイルからの読込</h6></div>
<div class="ms-4">
    読み込むCSVファイルの各項目が何番目にあるかを指定してください。<br>
    最初の１行はタイトル行として読み飛ばします。<br>
    連絡先は２項目を指定できます。<br>
    駐車券、バス券は、その項目に含まれるキーワードも入力してください。
</div>

<form action="{{ url('admin/csvImport') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <!-- CSVファイルの構成設定 -->
    <div class=" d-flex m-1">
        <label class = "w-25  text-end">氏名:</label>
        <input type="text" name ="csv_name" class=" w-25 border border-dark rounded-1 bg-info text-end " value="8">
    </div> 

    <div class="d-flex m-1">
        <label class = "w-25  text-end">email:</label>
        <input type="text" name ="csv_email" class=" w-25 border border-dark rounded-1 bg-info text-end " value="39">
    </div> 

    <div class="d-flex m-1">
        <label class = "w-25 text-end">連絡先:</label>
        <input type="text" name ="csv_phone1" class=" w-25 border border-dark rounded-1 bg-info text-end " value="18">
        <input type="text" name ="csv_phone2" class=" w-25 border border-dark rounded-1 bg-info text-end " value="40">
    </div> 

    <div class="d-flex m-1">
        <label class = "w-25 text-end">ナンバー:</label>
        <input type="text" name ="csv_zekken" class=" w-25 border border-dark rounded-1 bg-info text-end " value="43">
    </div> 

    <div class="d-flex m-1">
        <label class = "w-25 text-end">参加クラス:</label>
        <input type="text" name ="csv_category" class=" w-25 border border-dark rounded-1 bg-info text-end " value="7">
    </div>

    <div class="d-flex m-1">
        <label class = "w-25 text-end">駐車券:</label>
        <input type="text" name ="csv_park" class=" w-25 border border-dark rounded-1 bg-info text-end " value="7">
        <input type="text" name = "csv_park_keyword" class=" w-25 border border-dark rounded-1 bg-info text-end " value="駐車券付き">
    </div>

    <div class="d-flex m-1">
        <label class = "w-25 text-end">バス券:</label>
        <input type="text" name ="csv_bus" class=" w-25 border border-dark rounded-1 bg-info text-end " value="7">
        <input type="text" name = "csv_bus_keyword" class=" w-25 border border-dark rounded-1 bg-info text-end " value="シャトルバス">
    </div> 
    <!-- CSVファイルの選択 -->
    <div>
        <input type="file" name="csvFile" class="ms-3" id="csvFile">
    </div>
    <!-- ファイル追加または再読み込みの設定 -->
    <div>
        <label class="ms-3">CSVファイルの追加読込み</label>
        <input type="checkbox" name="csv_append" >
        <div class="ms-3">
            チェックすると、現在データベースにある参加者データは消さずに追加されます。<br>
            チェックしないと、現在データベースにある参加者データは消去されます。
        </div>
    </div>

    <div class="w-50">
        <div class="text-end">
            <button class="btn btn-primary ">CSVファイル読込</button>
        </div>
    </div>

</form>
</div>

<br>

<!-- スタッフアカウントの設定 -->

<div class="ms-3" ><h6>スタッフアカウントの設定</h6></div>
<div class="ms-4">
    スタッフ画面にアクセスできるemailとパスワードを設定します。<br>
    パスワードは暗号化されるため、現在のパスワードは表示されません。<br>
    登録済のスタッフのパスワード入力は不要です。パスワードを入力した場合は変更されます。<br>
    新規に登録するスタッフはemailとパスワードの両方を入力してください。<br>
</div>

<form action="{{ url('admin/staffaccount') }}" method="POST" >
    @csrf

    <!--スタッフアカウント設定タイトル -->
    <div class=" d-flex m-1">
        <label class = " w-20 text-end">　</label>
        <label class = " w-25 text-end">スタッフemail</label>  
        <label class= " w-25 text-end">パスワード</label>        
    </div>

    @php
        $num = 1
    @endphp
    <!-- 現在設定分を表示 -->
    @foreach ($p_staffs as $staff)
        <div class=" d-flex m-1" >
            <label class = "ms-3  w-20 text-end">{{ $num }}:</label>
            <input type="email" name ="staff_email_{{ $num }}" class="  w-25 border border-dark rounded-1 bg-info text-end " value="{{ $staff['email'] }}">
            <input type="text" name = "staff_pass_{{ $num }}" class="  w-25 border border-dark rounded-1 bg-info text-end " >
        </div>
        @php
            $num ++ ;
        @endphp
    @endforeach

    <!-- 空欄を表示 -->
    @for(  ;$num <= App\Constants::MAX_STAFF ; $num++)
        <div class=" d-flex m-1" >
            <label class = "ms-3  w-20 text-end">{{ $num }}:</label>
            <input type="email" name ="staff_email_{{ $num }}" class="  w-25 border border-dark rounded-1 bg-info text-end " >
            <input type="text" name = "staff_pass_{{ $num }}" class="  w-25 border border-dark rounded-1 bg-info text-end " >
        </div>
    @endfor

    <!-- 設定ボタン -->
    <div class="w-50">
        <div class="text-end">
            <button class="btn btn-primary ">スタッフアカウントの設定</button>
        </div>
    </div>
</form>   

<footer>
    <hr>
    <div class = "text-end">
        Mikawa Highland Trailrunning Race
    </div>
</footer>

</body>
</html>