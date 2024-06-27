<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Bootstrap5導入 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
    <!-- QRCode.jsのCDN -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    
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
<!-- グループ申込の場合だけ表示 -->
@if ( !empty($player->group_id ))
<div class="text-end">
    <a href="javascript:void(0)" onclick="goBack()" class="btn btn-primary m-1">戻る</a>
</div>
<script>
    function goBack(){ window.history.back(); }
</script>
@endif

 <!-- 誓約書にサイン済の場合 -->
 @if( $player->promise !== null)

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-9">
                <div class="card">
                    <div class="card-body text-center">
                        <h5 class="card-title ">ナンバービブ引換券</h5>
                        <hr> <!-- <hr> 水平線 -->
                        <div class="m-1">
                            ナンバー：{{ $player->zekken }}
                        </div>
                        <div class="m-1">
                            氏名:{{ $player->name }}
                        </div>
                        <div class="m-1">
                            参加クラス:{{ $player->category->category_name}}
                        </div>
                        <!-- QRコード発行 -->
                        <div class="container d-flex justify-content-center align-items-center ">
                            <div id="qrcode"></div>
                        </div>
                        <!-- バス券の表示 -->
                        @if ( $player->bus !== null)
                            <div class="m-4">
                                <button>シャトルバス券</button>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="ms-3">
        ・当日、受付にてこの画面をご提示いただき、ナンバービブを受け取ってください。<br>
        ・会場ではネット環境が悪い可能性がありますので、事前にこの画面をスクリーンショットで保存するか<br>
        ブラウザの印刷機能で印刷してお持ちください。
    </div>

    <!-- 駐車券がある場合 -->
    @if( $player->park !== null)
        <!-- <a href="{{ url('player/park/' . $player->id) }}">駐車券の発行</a> -->
        <div class="ms-4">
            駐車券がご利用になれます。以下「駐車券発券」をタップしてください。<br>
            新しいタブに駐車券が表示されますので、ブラウザの画面印刷機能で印刷してください。<br>
            ご自宅にプリンタがない場合は、ブラウザの保存機能でPDFをダウンロードしてコンビニのネットプリントをご利用ください。<br>
            <form action="{{ url('dompdf/pdf') }}" method="GET" target="_blank">
                <input type="hidden" name="name" value="{{ $player->name }}">
                <input type="hidden" name="zekken" value = "{{ $player->zekken }}">
                <input type="hidden" name="park" value="{{ $player->park->park_name }}">
                <div class="text-center">
                    <button class="btn btn-primary text-center" >駐車券発行</button>
                </div>
            </form>
        </div>
    @endif

    <!-- バス券がある場合 -->
    @if ( $player->bus !== null)
        <div class="m-4">
            シャトルバスをご利用いただけます。<br>
            乗車時にこの画面をご提示ください。
        </div>
    @endif
  
<!-- 誓約書にサインしていない場合 -->
@else
    <!-- 誓約書へのサイン -->
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-9">
                <div class="card">
                    <div class="card-body text-center">
                        <h5 class="card-title ">大会参加に関する誓約書</h5>
                        <hr> <!-- <hr> 水平線 -->
                        <div class="m-2">
                            三河高原トレイルランイング大会実行委員会殿
                        </div >
                        私は以下の事項について承諾の上参加します。<br>
                        ・自分あるいは第三者への傷害、被害について自己責任で参加します。<br>
                        ・プログラムに記載の事項をよく読み承認した上で参加します。<br>
                        ・映像あるいは情報について、主催者もしくは主催者が許可した者が撮影し、各種メディアで使うことを承諾します。<br>
                        <div class="text-center">
                            <h4> {{ $player->zekken}} {{ $player->name }}</h4>
                        </div>
                        <form action="{{ url('player/promise/' . $player->id) }}" method="POST" >
                        @csrf
                            <div class="m-3 text-center">
                                <button type="submit" class="btn btn-primary" >誓約します</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif

<script>
    // QRコードを生成する関数
    function generateQRCode(text) {
        var qrcodeContainer = document.getElementById('qrcode');
        qrcodeContainer.innerHTML = '';  // 既存のQRコードをクリア
        var qrcode = new QRCode(qrcodeContainer, {
            text: text,
            width: 128,   // QRコードの幅
            height: 128,  // QRコードの高さ
        });
    }

    // ページロード時にQRコードを生成
    document.addEventListener('DOMContentLoaded', function() {
        generateQRCode( '{{ $player->zekken }},{{ $player->id }}' );  // QRコードに含めるテキスト
    });
</script>

<footer>
    <hr>
    <div class = "text-end">
        Mikawa Highland Trailrunning Race
    </div>
</footer>

</body>
</html>