<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    @foreach($data as $one)
        {{ $one->name }}
        {{ $one->email}}
        {{ $one->category->name }}
        @if ($one->park_id)
           {{ $one->park->park_name}}
        @endif
        {{ $one->bus}}
        {{ $one->category->category_name}}
        <br>
    @endforeach    
</body>
</html>