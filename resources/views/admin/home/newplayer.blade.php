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

<!-- 戻るボタン -->
 <div class="text-end">
<a href="javascript:void(0)" onclick="goBack()" class="btn btn-primary m-1">戻る</a>
</div>
    <script>
    function goBack(){ window.history.back(); }
    </script>
<div class="container">
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
        <div class="card-body text-center">
            <h5 class="card-title ">新規参加者追加</h5>
            <hr> <!-- <hr> 水平線 -->

    <form action=" {{ url('admin/create_newplayer') }} " method="post" >
    @csrf
    
    <div class="m-2">
    <label>ナンバー：</label>
    <input type="text", name="zekken" class="bg-info">
    </div>
    <div class="m-2">
        <label>参加クラス：</label>
        <select name="category_id" class="bg-info">
        <option value="">指定なし</option>
        @foreach($categories as $category)
            <option value="{{ $category->id }}">{{ $category->category_name }}</option>
        @endforeach
    </select>
    </div>
    <div class="m-2">
    <label>氏名:</label>
    <input type="text" , name="name" class="bg-info">
    </div>
    <div class="m-2">
    <label>email:</label>
    <input type="email"  , name="email" class="bg-info">
    <div class="m-2">
    <label>駐車場:</label>
    <select name="park_id" class="bg-info" >
        <option value="">指定なし</option>
        @foreach($parks as $park)
            <option value="{{ $park->id }}">{{ $park->park_name}}</option>
    @endforeach
    </select>
    </div>
    <div class="m-2">
    <label>バス券:</label>
    <select name="bus" class="bg-info">
        <option value="">指定なし</option>
        <option value="1">バス券あり</option>
    </select>
    </div>
    <button type="submit" class="btn btn-primary m-3" >登録</button>
    </form>
    </div>
          </div>
        </div>
    </div>
  </div>

  <footer>
  <hr>
  <div class = "text-end">
  Mikawa Highland Trailrunning Race
</div>
</footer>

</body>
</html>