<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <!-- Bootstrap5導入 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>管理者ログイン</title>
</head>

<body>
<header>
    <h5 class="m-2">三河高原トレイルランニングレース　大会運営支援システム</h5>
    <hr>
</header>

@error('login')
    <p>{{ $message }}</p>
@enderror

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body text-center">
                    <h5 class="card-title ">管理者ログイン</h5>
                    <hr> <!-- <hr> 水平線 -->
                    <form method="POST" action="/admin/login" class="card-text">
                        @csrf
                        <div class="m-2">
                            <label>メールアドレス</label>
                            <input type="email" name="email" class="bg-info" value="{{ old('email') }}"><br>
                        </div>
                        <div class="m-2">
                            <label>パスワード</label>
                            <input type="password" name="password" class="bg-info" ><br>
                        </div>
                        <button type="submit" class="btn btn-primary m-3 " >ログイン</button>
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