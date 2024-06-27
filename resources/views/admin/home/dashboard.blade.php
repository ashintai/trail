
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
    <h5>三河高原トレイルランニングレース　大会運営支援システム</h5>
    <div class="text-end" >
        <a href="/admin/logout">ログアウト</a>
    </div>
    <hr>
</header>

<!-- 検索条件をコントローラから引き継ぐ -->
@php
$key_zekken = $append_param['zekken'];
$key_name = $append_param['name'];
$key_category_id = $append_param['category_id'];
$key_park_id = $append_param['park_id'];
$key_bus = $append_param['bus'];
$key_comment = $append_param['comment'];
@endphp

<div class="container-fluid">
    <div class="row">
        <!-- 画面左側3/12は検索エリア -->
        <div class="col-md-3 border border-dark">
        <!-- 検索用Form -->
            <form action="{{ url('admin/dashboard') }} " method="GET">
                @csrf
                <div class="form-group">
                    <label>ナンバー検索</label>
                    <input type="text" class="form-control" name="zekken" value="{{ $key_zekken }}" >
                </div>
                <div class="form-group">
                    <label >名前検索</label>
                    <input type="text" class="form-control" name="name" value="{{ $key_name }}">
                </div>
                <div class="form-group">
                    <!-- 参加クラスの条件 -->
                    <label for="category">参加クラス</label>
                    <br>
                    <select name="category_id" id="category">
                        <option value="">指定なし</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->category_name}}</option>
                        @endforeach
                    </select>
                    <!-- 参加クラスの検索条件引継ぎ -->
                    <script>
                        const selectElement_category = document.getElementById("category");
                        selectElement_category.value = "{{ $key_category_id }}" ;   
                    </script>
                </div>
                <div class="form-group">
                    <!-- 駐車場の条件 -->
                    <label for="park">駐車場</label>
                    <br>
                    <select name="park_id" id="park">
                        <option value="">指定なし</option>
                        @foreach($parks as $park)
                            <option value="{{ $park->id }}">{{ $park->park_name}}</option>
                    @endforeach
                    </select>
                    <!-- 駐車券の検索条件引継ぎ -->
                    <script>
                        const selectElement_park = document.getElementById("park");
                        selectElement_park.value = "{{ $key_park_id }}" ;   
                    </script>
                </div>
                <div class="form-group">
                    <!-- バス券の条件 検索条件はchecked で引き継ぐ-->
                    <label for="bus">バス券</label>
                    <input type="checkbox" name="bus" {{ $key_bus ? 'checked' : '' }}>
                </div>
                
                <div class="form-group">
                    <!-- 備考の条件 -->
                    <label for="comment">備考あり</label>
                    <input type="checkbox" name="comment"{{ $key_comment ? 'checked' : '' }} >
                </div>
            
                <!-- 検索ボタン -->
                <input type="submit" class="btn btn-primary mt-2" value="検索">
            </form>
            <br>
            <div class= "m-2">
                <form action="{{ url('admin/newplayer') }}" method="GET">
                    <button>新規参加者</button>
                </form>
            </div>
            <div class="m-2">
                <form action="{{ url('admin/initial') }}" method="GET">
                    <button>初期設定</button>
                </form>
            </div>
        </div>

        <!-- 画面右側9/12は一覧表示エリア -->
        <div class="col-md-9 border">

            @if( $data->isEmpty())
                検索結果は０でした。
            @endif
            
            <table class="table table-bordered table-striped table-hover">
                <thead>
                    <tr>
                        <th>参加クラス</th>
                        <th>ナンバー</th>
                        <th>氏名</th>
                        <th>バス</th>
                        <th>駐車</th>
                        <th>欠場</th>
                        <th>備考</th>
                        <th>リンク</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data as $one)
                    <tr>
                        <td>{{ $one->category->category_name}}</td>
                        <td>{{ $one->zekken}}</td>
                        <td>{{ $one->name}}</td>
                        <td>
                        @if($one->bus)
                            バス
                        @endif
                        </td>
                        <td>
                        @if( $one->park)
                            {{ $one->park->park_name }}
                        @endif
                        </td>
                        <td>
                        @if( $one->dns)
                                欠場
                        @endif
                        </td>
                        <td>{{ $one->comment }}</td>
                        <td>
                            <a class="btn btn-primary" href="{{ url('admin/edit/' . $one->id) }}">編集</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <!-- ページネーションを表示するための設定   -->
            {{ $data->links('pagination::bootstrap-5') }}
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