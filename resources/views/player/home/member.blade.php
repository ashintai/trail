<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Bootstrap5導入 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="UTF-8">
    <title>三河高原トレラン</title>

</head>

<body>
<header>
        <h5 class="m-2">三河高原トレイルランニングレース</h5>
        <div class="text-end">
    <a href="/player/logout">ログアウト</a>
  </div>
        <hr>
    </header>
    
        <!-- 戻るボタン -->
        <div class="w-50">
    <div class="text-end">
        <a href=" {{ url('player/login') }}" class="btn btn-primary m-1">戻る</a>
    </div>
    </div>

    <div class="container">
    <div class="row justify-content-center">
        <div class="col-md-9">
          <div class="card">
            <div class="card-body text-center">
              <h5 class="card-title ">グループ申込メンバー選択</h5>
              <hr> <!-- <hr> 水平線 -->

    @foreach($member as $mem)
    {{$mem->name}} 
    <a href="{{ url('player/member/' . $mem->id) }}">選択</a>
    <br>
    @endforeach

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