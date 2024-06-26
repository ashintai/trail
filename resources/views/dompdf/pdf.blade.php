<!-- 駐車券のPDF出力用のフォーマット -->
<!DOCTYPE html>
<!-- <html lang="{{ str_replace('_', '-', app()->getLocale()) }}"> -->
<html lang="ja">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <title>駐車券PDF出力</title>
        <style>
        /* dompdf日本語文字化け対策 */
            @font-face {
                font-family: ipag;
                font-style: normal;
                font-weight: normal;
                src: url('{{ storage_path('fonts/ipag.ttf') }}') format('truetype');
            }
            @font-face {
                font-family: ipag;
                font-style: bold;
                font-weight: bold;
                src: url('{{ storage_path('fonts/ipag.ttf') }}') format('truetype');
            }
            body {
                font-family: ipag !important;
            }   
        </style>

        <!-- 画像とテキストを重ねて表示するためのスタイル指定 -->
        <style>
            .image-container {
                position: relative;
            }
            /* 氏名・ナンバーの文字位置 */
            .overlay-text {
                position: absolute;
                top: 55%;
                left: 0%;
                font-size:40px;
            }
            /* 駐車場記号の位置 */
            .overlay-park{
                position: absolute;
                top: 5%;
                left: 25%;
                font-size:400px;
                color:blue;
            }

        </style>
    </head>
    <body>
        <!-- 書式画像はbase64形式で送られてくる -->
        <div class="image-container">
            <img src="data:image/jpg;base64,{!! $format_data !!}" alt="Image" style="width:100%">
           
            <div class="overlay-park">
                {{ $data['park']}}
            </div>
            
            <div class="overlay-text">   
                ナンバー：{{ $data['zekken'] }}<br>
                {{ $data['name'] }}
            </div>
        </div>
    </body>
</html>
