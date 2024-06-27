<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <!-- Bootstrap5導入 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>スタッフ＞QR読取り</title>
</head>
<body>
<header>
  <h5 class="m-2">三河高原トレイルランニングレース　大会運営支援システム</h5>
  <hr>
</header>

<body>
    <!-- 戻るボタン -->
    <div class="text-end">    
        <a href="javascript:void(0)" onclick="goBack()" class="btn btn-primary m-1">戻る</a>
    </div>
    <script>
        function goBack(){
        window.history.back();
        }
    </script>

    <!-- QRコード読み取り -->
     <!-- QRコード画像を入れるための　 video要素　id=prevew -->
    <video id="preview"></video>
     <!-- QRコードを解釈するInstascanライブラリを導入 -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/instascan/1.0.0/instascan.min.js"></script>
    <script>
        // 新しいスキャンインスタンス生成しid=prevewのvideo要素を渡す＝Instascanが提供する
        let scanner = new Instascan.Scanner({ video: document.getElementById('preview') });
        // 生成されたスキャンにイベントリスナーを設定する　QRコードを読み取ったときに内容が変数contentに入る
        scanner.addListener('scan', function (content) {
            // アラート機能でQRコードの内容を表示
            alert('QRコードの内容: ' + content);
            // fetch でサーバーにQRコードの内容をPOST送信　送り先は　Route'/scan'
            fetch('/scan', {
                method: 'POST',
                // 送信するデータ（Request）のタイプはJSONでcsrf対応する
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                // 送信本体　qr_content という名前でQR内容content を送信
                body: JSON.stringify({ qr_content: content })
            });
        });
        // getCamerasメソッドで利用可能なカメラのリストを取得　非同期処理
        Instascan.Camera.getCameras().then(function (cameras) {
            // カメラ取得に成功した場合、then以下が処理される　利用可能なカメラリストはcameraで渡される
            if (cameras.length > 0) {
                // 利用可能なカメラの数が０以上であればカメラを起動
                scanner.start(cameras[0]);
            } else {
                // 利用可能なカメラがない場合はエラーをコンソールに出力
                console.error('カメラが見つかりません。');
            }
        }).catch(function (e) {
            // カメラの取得に失敗した場合はエラーをコンソールへ出力
            console.error(e);
        });
    </script>

    <!-- QRコード読み取り　ここまで -->

<!-- 戻るボタン -->
<div class="text-center">
    <a href=" {{ url('staff/') }}" class="btn btn-primary m-1">戻る</a>
</div> 

<!-- フッター -->
<footer>
  <hr>
  <div class = "text-end">
  Mikawa Highland Trailrunning Race
</div>
</footer>
</body>
</html>
