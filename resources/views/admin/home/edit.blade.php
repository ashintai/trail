<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <!-- Bootstrap5導入 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>三河高原トレラン＞管理者</title>
</head>
<body>
    <header>
        <h5 class="m-2">三河高原トレイルランニングレース　大会運営支援システム</h5>
        <hr>
    </header>

    <!-- 戻るボタン -->
    <!-- Windowsの前ページに戻る関数をscriptで呼び出す -->
    <div class="text-end">    
        <a href="javascript:void(0)" onclick="goBack()" class="btn btn-primary m-1">戻る</a>
    </div>
    <script>
        function goBack(){
        window.history.back();
        }
    </script>

    <!-- // バリデーションエラーの表示 -->
    @if ($errors->any())
        <div >
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ url('admin/edit_player') }} " method="POST">
    @csrf
    <!-- IDの表示 -->
    <div class="container">
    <div class="d-flex m-1">
        <div class="w-25 text-end">
            ID:
        </div>
        <div class="w-75">
            <div class="form-control border border-dark rounded-1 text-end">
                {{ $one->id }}
            </div>
        </div>
    </div>
    <!-- ID を送る -->
    <input type="hidden" name="id" value="{{ $one->id }}">

    <!-- ゼッケンの編集 -->
    <div class="d-flex m-1">
        <div class="w-25 text-end">
           ナンバー:
        </div>
        <div class="w-75">
            <input type="text" class="form-control border border-dark rounded-1 text-end bg-info" value="{{ $one->zekken }}" name="zekken" >
        </div>
    </div>

    <!--氏名の編集 -->
    <div class="d-flex m-1">
        <div class="w-25 text-end">
           氏名:</div>
        <div class="w-75">
            <input type="text" class="form-control border border-dark rounded-1 text-end bg-info" value="{{ $one->name }}" name="name" >
        </div>
    </div>

    <!-- 参加クラスの表示 -->
    <div class="d-flex m-1">
        <div class="w-25 text-end">
          参加クラス:</div>
        <div class="w-75">
            <select name="category_id" class="form-control border border-dark rounded-1 text-end bg-info" >
            @foreach($categories as $category)
                @if( $category->id === $one->category_id )
                <option value="{{ $category->id }}" selected >{{ $category->category_name }}</option>
                @else
                <option value="{{ $category->id }}" >{{ $category->category_name }}</option>
                @endif
            @endforeach    
            </select>
        </div>
    </div>

    <!-- 備考の表示 -->
    <div class="d-flex m-1">
        <div class="w-25 text-end">
           備考:</div>
        <div class="w-75">
            <input type="text" class="form-control border border-dark rounded-1 text-end bg-info" value="{{ $one->comment }}" name="comment" >
        </div>
    </div>

    <!-- 欠場の表示 -->
    <div class="d-flex m-1">
        <div class="w-25 text-end">
        欠場:</div>
        <div class="w-75">
            <select name="dns" class="form-control border border-dark rounded-1 text-end bg-info" >
            <option value="">－</option>
            @if( $one->dns !== null)
                <option value="1" selected >欠場</option>
            @else
                <option value="1" >欠場</option>
            @endif
            </select>
        </div>
    </div>

    <!-- 誓約の表示 -->
    <div class="d-flex m-1">
        <div class="w-25 text-end">
        誓約:</div>
        <div class="w-75">
            <select name="promise" class="form-control border border-dark rounded-1 text-end bg-info" >
            <option value="">－</option>
            @if( $one->promise !== null)
            <option value="1" selected >誓約済</option>
            @else
            <option value="1" >誓約済</option>
            @endif
            </select>
        </div>
    </div>
   
    <!-- 駐車券の表示 -->
    <div class="d-flex m-1">
        <div class="w-25 text-end">
        駐車券:</div>
        <div class="w-75">
            <select name="park_id" class="form-control border border-dark rounded-1 text-end bg-info" >
            <option value="">駐車券なし</option>
            @foreach( $parks as $park)
            @if( $one->park_id === $park->id )
            <option value="{{ $park->id }}" selected >{{ $park->park_name }}</option>
            @else
            <option value="{{ $park->id }}" >{{ $park->park_name}}</option>
            @endif
            @endforeach
            </select>
        </div>
    </div>

    <!-- バス券の表示 -->
    <div class="d-flex m-1">
        <div class="w-25 text-end">
        バス券:</div>
        <div class="w-75">
            <select name="bus" class="form-control border border-dark rounded-1 text-end bg-info" >
            <option value="">－</option>
            @if( $one->bus !== null)
            <option value="1" selected >バス券あり</option>
            @else
            <option value="1" >バス券あり</option>
            @endif
            </select>
        </div>
    </div>    

    <!-- バス乗車の有無の表示 -->
    <div class="d-flex m-1">
        <div class="w-25 text-end">
        バス乗車:</div>
        <div class="w-75">
            <select name="bus_ride" class="form-control border border-dark rounded-1 text-end bg-info" >
            <option value="">－</option>
            @if( $one->bus_ride !== null)
            <option value="1" selected >バス乗車済</option>
            @else
            <option value="1" >バス乗車済</option>
            @endif
            </select>
        </div>
    </div> 

    <!-- 受付の表示 -->
    <div class="d-flex m-1">
        <div class="w-25 text-end">
        受付:</div>
        <div class="w-75">
            <select name="reseption" class="form-control border border-dark rounded-1 text-end bg-info" >
            <option value="">－</option>
            @if( $one->reseption !== null)
            <option value="1" selected >受付済</option>
            @else
            <option value="1" >受付済</option>
            @endif
            </select>
        </div>
    </div>  

    <!-- メールアドレスの表示 -->
    <div class="d-flex m-1">
        <div class="w-25 text-end">
           メールアドレス:</div>
        <div class="w-75">
            <input type="text" class="form-control border border-dark rounded-1 text-end bg-info" value="{{ $one->email }}" name="email" >
        </div>
    </div>

    <!-- 連絡先の表示 -->
    <div class="d-flex m-1">
        <div class="w-25 text-end">
           連絡先:</div>
        <div class="w-75">
            <input type="text" class="form-control border border-dark rounded-1 text-end bg-info" value="{{ $one->phone }}" name="phone" >
        </div>
    </div>

    <!-- パスワードの入力 -->
    <div class="d-flex m-1">
        <div class="w-25 text-end">
           パスコード:</div>
        <div class="w-75">
            <input type="text" class="form-control border border-dark rounded-1 text-end bg-info" name="password" >
        </div>
    </div>
    <div>
        管理者がパスコードを設定したい場合は、パスコードを入力してください。<br>
        ただし、参加者が自分でパスコードを発行した場合は、置き換わります。<br>
    </div>


    <div class="text-end">
        <button class="btn btn-primary" >編集登録</button>
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