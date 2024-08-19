<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <!-- Bootstrap5導入 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>三河高原トレラン</title>
</head>
<body>
  <header>
  <h5 class="m-2">三河高原トレイルランニグレース</h5>
<hr>
</header>

@error('login')
    <p class="text-danger">{{ $message }}</p>
    @enderror

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body text-center">
                    <h5 class="card-title ">参加者ログイン</h5>
                    <hr> <!-- <hr> 水平線 -->

                    <form method="POST" action="/player/login">
                    @csrf
                        <div class="m-2">
                            <label>メールアドレス</label>
                            <input type="email" name="email" class="bg-info" value="{{ old('email')}}"><br>
                        </div>
                        <div class="m-2">
                            <label>パスコード</label>
                            <input type="password" name="password" class="bg-info"><br>
                        </div>
                        <button type="submit" class="btn btn-primary m-3">ログイン</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="ms-3">
    初回ログイン時は、ご登録のメールアドレスのみ入力し（パスコードは空欄のまま）「ログイン」をタップしてください。<br>
    ご登録のメールアドレス宛て（エントリー時のメールアドレス）にパスコードが送信されます。<br>
    パスコードは１度発行されますと、以降のログインで有効です。<br>
    もしパスコードをお忘れの場合は、再度メールアドレスのみを入力し「ログイン」をタップしてください。<br>
    新しいパスコードが発行されます。<br>
    なお、メールはGmailで発信されますので、@gmailまたはshintai.akira@gmail.comからのメールが受信可能な設定をお願いします。<br>
    メールが届かない場合、迷惑メールに振り分けられていないかもご確認ください。
    <br>
    ご不明な点あれば、以下までメールでお問合せください。<br>
    三河高原トレイルランニング大会実行委員会　事務局　info@mikawatrail.com<br>
</div>
<br>

<a href="https://mikawatrail.com/%e3%83%ad%e3%82%b0%e3%82%a4%e3%83%b3/" class="btn btn-primary" style="text-align: center" >戻る</a>

<footer>
    <hr>
    <div class = "text-end">
        Mikawa Highland Trailrunning Race
    </div>
</footer>

</body>
</html>