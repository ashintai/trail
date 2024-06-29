<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <!-- Bootstrap5導入 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- QRデータをJavascriptからPOST送信する際に必要なcsrfの指定 -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>スタッフ＞QR読取り</title>
</head>

<body>
<header>
  <h5 class="m-2">三河高原トレイルランニングレース　大会運営支援システム</h5>
  <hr>
</header>

<!-- 戻るボタン -->
<div class="text-end">
    <a href="{{ url('staff/') }}" class="btn btn-primary m-1">戻る</a>
</div> 

    <canvas id="canvas" style="width:100%;"></canvas>

    <!-- jsQRのCDN -->
    <script src="https://cdn.jsdelivr.net/npm/jsqr@1.4.0/dist/jsQR.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.18.0/axios.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const video = document.createElement('video');
            const canvasElement = document.getElementById('canvas');
            const canvas = canvasElement.getContext('2d');

            // Axios非同期POST通信でのcsrf設定
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            axios.defaults.headers.common['X-CSRF-TOKEN'] = csrfToken;

            navigator.mediaDevices.getUserMedia({ video: { facingMode: 'environment' } }).then(function(stream) {
                video.srcObject = stream;
                video.setAttribute('playsinline', true); // iOS対応
                video.play();
                requestAnimationFrame(tick);
            });

            // Axiosによる非同期通信の際にサーバー側処理中は読み飛ばすためのフラグ初期設定
            let checking = false;

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
                        // alert("QR Code Data:" + code.data);
                        // QRコードが見つかった場合の処理をここに書く

                        // Axiosによる非同期通信
                        // 処理先のurl
                        const url = '/staff/qrset';
                        // 読み取ったQRデータ
                        var qrCodeData = code.data;
                        
                        if(!checking){
                            // 非同期処理中の場合はスキップ
                            checking = true;

                            axios.post(url, {data : qrCodeData} )
                            // axiosでPOST送信
                            .then((response) => {
                                const result = response.data.result;
                                // 非同期で帰ってきた結果の受取
                                if( result ){
                                    // 結果resultがtrueのとき
                                    const message = response.data.message;
                                    // 結果からnameデータを取り出し
                                    alert( message );
                                    // メッセージを表示
                                }else{
                                    // 結果resultがfalseのとき
                                    alert('このQRは無効です');
                                }
                            })
                            .catch((error) => {})
                            // 非同期がエラーで帰ったときは何もしない
                            .then(() => {
                                checking = false;
                                // 非同期処理が終わったら、フラグを下す
                            })

                        }


                        // // JavaScriptの変数にデータを格納
                        // const data = {
                        //    qrcode: code.data,
                        //    };
                        // // データを自動的にPOST送信する
                        // fetch('/qrset', {
                        //      headers: {
                        //         'Content-Type': 'application/json',
                        //         'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        //     },
                        //     body: JSON.stringify(data)
                        // })
                        // .then(response => response.json())
                        // .then(data => {
                        //     console.log('Success:', data);
                        // })
                        // .catch((error) => {
                        //     console.error('Error:', error);
                        // });
 
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
