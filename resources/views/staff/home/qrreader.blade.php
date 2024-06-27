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
<div class="text-ens">
    <a href=" {{ url('staff/') }}" class="btn btn-primary m-1">戻る</a>
</div> 

<body>
    <canvas id="canvas" style="width:100%;"></canvas>

    <!-- jsQRのCDN -->
    <script src="https://cdn.jsdelivr.net/npm/jsqr@1.4.0/dist/jsQR.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const video = document.createElement('video');
            const canvasElement = document.getElementById('canvas');
            const canvas = canvasElement.getContext('2d');

            navigator.mediaDevices.getUserMedia({ video: { facingMode: 'environment' } }).then(function(stream) {
                video.srcObject = stream;
                video.setAttribute('playsinline', true); // iOS対応
                video.play();
                requestAnimationFrame(tick);
            });

            function tick() {
                if (video.readyState === video.HAVE_ENOUGH_DATA) {
                    canvasElement.height = video.videoHeight;
                    canvasElement.width = video.videoWidth;
                    canvas.drawImage(video, 0, 0, canvasElement.width, canvasElement.height);
                    const imageData = canvas.getImageData(0, 0, canvasElement.width, canvasElement.height);
                    const code = jsQR(imageData.data, imageData.width, imageData.height, {
                        inversionAttempts: "dontInvert",
                        // "dontInvert", "onlyInvert", "attemptBoth"のどれか
                    });

                    if (code) {
                        console.log("Found QR code", code);
                        alert("QR Code Data:" + code.binaryData);
                        // QRコードが見つかった場合の処理をここに書く
                    }
                }
                requestAnimationFrame(tick);
            }
        });
    </script>
    <!-- QRコード読み取り　ここまで -->

<!-- フッター -->
<footer>
  <hr>
  <div class = "text-end">
  Mikawa Highland Trailrunning Race
</div>
</footer>
</body>
</html>
