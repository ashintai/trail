<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <!-- Bootstrap5導入 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>参加者詳細</title>
</head>
<body>
<header>
    <h5 class="m-2">三河高原トレイルランニングレース　大会運営支援システム</h5>
    <hr>
</header>
    
<!-- 戻るボタン -->
<div class="text-end">
    <a href=" {{ url('staff/') }}" class="btn btn-primary m-1">戻る</a>
</div>
   
<!-- // バリデーションエラーの表示 -->
@if ($errors->any())
    <div >
        <ul>
            @foreach ($errors->all() as $error)
                <li class="text-danger">{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="ms-3">
    この詳細画面では「備考」のみ入力することができます。<br>
    入力後「備考登録」をタップしてください。
</div>

<form action="{{ url('staff/update') }} " method="POST">
@csrf
    <!-- IDの表示 -->
    <div class="container">
        <div class="d-flex m-1">
            <div class="w-25 text-end">
                ID:
            </div>
            <div class="w-75">
                <div class="form-control border border-dark rounded-1 text-end">
                    {{ $one->id }}
                </div>
            </div>
        </div>
        <!-- ID を送る -->
        <input type="hidden" name="id" value="{{ $one->id }}">

        <!-- ゼッケンの表示 -->
        <div class="d-flex m-1">
            <div class="w-25 text-end">
                ナンバー:
            </div>
            <div class="w-75">
                <div class="form-control border border-dark rounded-1 text-end ">
                    {{ $one->zekken }}
                </div>
            </div>
        </div>

        <!--氏名の編集 -->
        <div class="d-flex m-1">
            <div class="w-25 text-end">
                氏名:
            </div>
            <div class="w-75">
                <div class="form-control border border-dark rounded-1 text-end ">
                    {{ $one->name }}
                </div>
            </div>
        </div>

        <!-- 参加クラスの表示 -->
        <div class="d-flex m-1">
            <div class="w-25 text-end">
                参加クラス:
            </div>
            <div class="w-75">
                <div class="form-control border border-dark rounded-1 text-end ">
                    {{ $one->category->category_name}}
                </div>
            </div>
        </div>

        <!-- 備考の表示 -->
        <div class="d-flex m-1">
            <div class="w-25 text-end">
                備考:
            </div>
            <div class="w-75">
                <input type="text" class="form-control border border-dark rounded-1 text-end bg-info" value="{{ $one->comment }}" name="comment" >
            </div>
        </div>

        <!-- 欠場の表示 -->
        <div class="d-flex m-1">
            <div class="w-25 text-end">
                欠場:
            </div>
            <div class="w-75">
                <div class="form-control border border-dark rounded-1 text-end ">
                    @if( $one->dns !== null)
                        欠場
                    @else
                        －
                    @endif
                </div>
            </div>
        </div>

        <!-- 誓約の表示 -->
        <div class="d-flex m-1">
            <div class="w-25 text-end">
                誓約:
            </div>
            <div class="w-75">
                <div class="form-control border border-dark rounded-1 text-end ">
                    @if( $one->promise !== null)
                        誓約済
                    @else
                        －
                    @endif
                </div>
            </div>
        </div>
   
        <!-- 駐車券の表示 -->
        <div class="d-flex m-1">
            <div class="w-25 text-end">
                駐車券:
            </div>
            <div class="w-75">
                <div class="form-control border border-dark rounded-1 text-end ">
                    @if( $one->park !== null )
                        {{ $one->park->park_name}}
                    @else
                        －
                    @endif
                </div>    
            </div>
        </div>

        <!-- バス券の表示 -->
        <div class="d-flex m-1">
            <div class="w-25 text-end">
                バス券:
            </div>
            <div class="w-75">
                <div class="form-control border border-dark rounded-1 text-end ">
                    @if( $one->bus !== null)
                        バス券あり
                    @else
                        －
                    @endif
                </div>
            </div>
        </div>    

        <!-- バス乗車の有無の表示 -->
        <div class="d-flex m-1">
            <div class="w-25 text-end">
                バス乗車:
            </div>
            <div class="w-75">
                <div class="form-control border border-dark rounded-1 text-end ">
                    @if( $one->bus_ride !== null)
                        バス乗車済
                    @else
                        －
                    @endif
                </div>
            </div>
        </div> 

        <!-- 受付の表示 -->
        <div class="d-flex m-1">
            <div class="w-25 text-end">
                受付:
            </div>
            <div class="w-75">
                <div class="form-control border border-dark rounded-1 text-end ">
                    @if( $one->reseption !== null)
                        受付済
                    @else
                        －
                    @endif
                </div>
            </div>
        </div>  

        <!-- メールアドレスの表示 -->
        <div class="d-flex m-1">
            <div class="w-25 text-end">
                メールアドレス:
            </div>
            <div class="w-75">
                <div class="form-control border border-dark rounded-1 text-end" >
                    {{ $one->email }}
                </div>
            </div>
        </div>

        <!-- 連絡先の表示 -->
        <div class="d-flex m-1">
            <div class="w-25 text-end">
                連絡先:
            </div>
            <div class="w-75">
                <div class="form-control border border-dark rounded-1 text-end ">
                    @if ( $one->phone !== null)
                        {{ $one->phone }}
                    @else
                        －
                    @endif
                </div>
            </div>
        </div>

        <div class="text-end">
            <button class="btn btn-primary" >備考登録</button>
        </div>
   </div>
</form>

<footer>
    <hr>
    <div class = "text-end">
        Mikawa Highland Trailrunning Race
    </div>
</footer>

</body>
</html>