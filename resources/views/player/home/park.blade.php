<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>駐車券</title>
</head>
<body>

<h4>駐車券</h4>

<h1>{{ $player->park->park_name }}</h1>
{{ $player->name }}<br>

<a href="javascript:void(0)" onclick="goBack()" class="btn btn-primary m-1">戻る</a>
    <script>
    function goBack(){ window.history.back(); }
    </script>

</body>
</html>