<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <!-- Bootstrap5導入 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>スタッフ＞QR読取り</title>

    <!-- カメラ用スタイル -->
    <style>

canvas {
    padding-left: 0;
    padding-right: 0;
    margin-left: auto;
    margin-right: auto;
    display: block;
    width: 50%;
}

</style>
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

<div id="app">
    <div style="text-align:center;font-size:35px;">QRコードを読みとって自動ログインできます</div>
    <br>
    <canvas ref="canvas"></canvas>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.19.0/axios.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/vue@2.6.10/dist/vue.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jsqr@1.4.0/dist/jsQR.min.js"></script>
<script>

    new Vue({
        el: '#app',
        data: {
            video: null,
            canvas: null,
            context: null,
            uuid: '',
            completed: false,
            componentWidth: -1,
        },
        computed: {
            hasUuid() {

                return (this.uuid !== '');

            }
        },
        methods: {
            renderFrame() {

                if(!this.hasUuid && !this.completed) { // まだQRコードが読み込まれていない場合

                    const video = this.video;
                    const canvas = this.canvas;
                    const context = this.context;

                    if(video.readyState === video.HAVE_ENOUGH_DATA) {

                        context.drawImage(video, 0, 0, canvas.width, canvas.height);
                        const imageData = context.getImageData(0, 0, canvas.width, canvas.height);
                        const code = jsQR(imageData.data, imageData.width, imageData.height);

                        if(code) {

                            this.uuid = code.data;
                            axios.post('/auth/qr_login', { uuid: this.uuid })
                                .then((response) => {

                                    const result = response.data.result;
                                    const user = response.data.user;

                                    if(result) {

                                        this.completed = true;
                                        alert('「'+ user.name +'」さん、おはようございます！');
                                        // location.href = '/user'; // ここでリダイレクト

                                    } else {

                                        console.log('ログイン失敗..');

                                    }

                                })
                                .catch(error => {

                                    console.log(error);

                                })
                                .finally(() => {

                                    this.uuid = '';

                                });

                        }

                    }

                }

                requestAnimationFrame(this.renderFrame);

            },
            initializeVideo(videoParams) {

                return navigator.mediaDevices.getUserMedia(videoParams)

            },
            initializeVideoThen(stream) {

                this.video.srcObject = stream;
                this.video.play();

            }
        },
        mounted() {

            this.video = document.createElement('video');
            this.video.addEventListener('loadedmetadata', () => {

                this.canvas.width = this.componentWidth;
                this.canvas.height = Number(this.canvas.width * this.video.videoHeight / this.video.videoWidth);
                this.renderFrame();

            });
            this.video.setAttribute('autoplay', '');
            this.video.setAttribute('muted', '');
            this.video.setAttribute('playsinline', '');
            this.canvas = this.$refs.canvas;
            this.context = this.canvas.getContext('2d');
            this.componentWidth = this.canvas.offsetWidth;

            const videoParams = {
                audio: false,
                video: {
                    facingMode: {
                        exact: 'environment'
                    },
                    width: { ideal: 1080 },
                    height: { ideal: 720 }
                }
            };

            this.initializeVideo(videoParams)
                .then(this.initializeVideoThen)
                .catch(() => {

                    this.initializeVideo({ video: true })
                        .then(this.initializeVideoThen)

                });

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
