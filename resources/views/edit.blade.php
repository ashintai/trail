<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <!-- Bootstrap5導入 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>参加者詳細</title>
</head>
<body>
    <header>
        <h4>参加者の詳細情報</h4>
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
    
    <!-- IDの表示 -->
    <div class="container">
    <div class="d-flex m-1">
        <div class="w-25 text-end">
            ID:</div>
        <div class="w-75 border border-dark rounded-1 text-end">
            {{ $one->id }}
        </div>
    </div>
    <!-- ゼッケンの表示 -->
    <div class="d-flex m-1">
        <div class="w-25 text-end">
            ナンバー:</div>
        <div class="w-75 border border-dark rounded-1 text-end">
            {{ $one->zekken }}
        </div>
    </div>
    <!-- 氏名の表示 -->
    <div class="d-flex m-1">
        <div class="w-25 text-end">
            氏名:</div>
        <div class="w-75 border border-dark rounded-1 text-end">
            {{ $one->name }}
        </div>
    </div>
    <!-- 参加クラスの表示 -->
    <div class="d-flex m-1">
        <div class="w-25 text-end">
            参加クラス:</div>
        <div class="w-75 border border-dark rounded-1 text-end ">
            {{ $one->category->category_name }}
        </div>
    </div>
    <!-- 欠場の表示 -->
    <div class="d-flex m-1">
        <div class="w-25 text-end">
            欠場:</div>
        <div class="w-75 border border-dark rounded-1 text-end ">
            @if( $one->dns)
                欠場
            @endif
        </div>
    </div>
    <!-- 誓約の表示 -->
    <div class="d-flex m-1">
        <div class="w-25 text-end">
            誓約:</div>
        <div class="w-75 border border-dark rounded-1 text-end ">
            @if( $one->promise)
                済
            @endif
        </div>
    </div>

    <!-- 駐車券の表示 -->
    <div class="d-flex m-1">
        <div class="w-25 text-end">
            駐車券:</div>
        <div class="w-75 border border-dark rounded-1 text-end">
            @if($one->park_id)
                {{ $one->park->park_name }}
            @endif
        </div>
    </div>
    <!-- バス券の表示 -->
    <div class="d-flex m-1">
        <div class="w-25 text-end">
            バス券:</div>
        <div class="w-75 border border-dark rounded-1 text-end">
            @if( $one->bus)
             あり
            @endif
        </div>
    </div>
    <!-- バス乗車の表示 -->
    <div class="d-flex m-1">
        <div class="w-25 text-end">
            バス乗車:</div>
        <div class="w-75 border border-dark rounded-1 text-end">
            @if( $one->bus_ride)
             あり
            @endif
        </div>
    </div>
    <!-- 受付の表示 -->
    <div class="d-flex m-1">
        <div class="w-25 text-end">
            受付:</div>
        <div class="w-75 border border-dark rounded-1 text-end">
            @if( $one->reception)
             通過
            @endif
        </div>
    </div>
    <!-- メールアドレスの表示 -->
    <div class="d-flex m-1">
        <div class="w-25 text-end">
            メールアドレス:</div>
        <div class="w-75 border border-dark rounded-1 text-end">
            {{ $one->email }}
        </div>
    </div>
    <!-- 連絡先の表示 -->
    <div class="d-flex m-1">
        <div class="w-25 text-end">
            連絡先:</div>
        <div class="w-75 border border-dark rounded-1 text-end">
            {{ $one->phone }};
        </div>
    </div>
    <!-- 備考の表示と入力 -->
    <div class="d-flex m-1">
        <div class="w-25 text-end">
            備考:</div>
            <div class="w-75">
        <form action="" >
            @csrf
            <input type="text" class="w-100 bg-warning" value="{{ $one->comment}}">
            <button type="submit" class="btn btn-primary m-1">備考入力</button>
        </form>
    </div>
  
</body>
</html>