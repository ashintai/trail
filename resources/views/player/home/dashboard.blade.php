<html>
<head>
  <title>参加者画面トップ</title>
</head>
<body>
  <h1>参加者画面トップ</h1>

  @if (session('login_msg'))
  <p>{{ session('login_msg') }}</p>
  @endif

  @if (Auth::guard('players')->check())
  <div>ユーザーID {{ Auth::guard('players')->user()->name }}でログイン中</div>
  @endif

  
  <div>
    <a href="/player/logout">ログアウト</a>
  </div>
</body>
</html>