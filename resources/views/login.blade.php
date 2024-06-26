<!DOCTYPE html>
<html lang="jp">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>参加者ログイン</title>
</head>
<body>
    <form action="{{ url('group') }}" method="get" >
        @csrf
        <div>メールアドレス</div>
        <input type="email" name="email" mexlength="255" required>
        <button class="btn btn-primary" type="submit" >ログイン</button>
    </form>
    
</body>
</html>