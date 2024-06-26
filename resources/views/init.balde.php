<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DB初期化</title>
</head>
<body>
    
DBの初期化

@foreach($cat_data as $cat)

{{ $cat->id }}<br>
{{$cat->category_name }}<br>
@endforeach


</body>
</html>