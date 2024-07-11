<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\pdf; 
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
// Debug用にLogを残すため追加
use Illuminate\Support\Facades\Log;

// 駐車券のPDFを発行
// 画像ファイルもBase64形式で渡す

class DompdfController extends Controller
{
    //PDFの生成
    public function generatePDF(Request $request)
    {
        
    // フォントへのアクセスを確認
    Log::info('****************************************************************');
    $fontPath = storage_path('fonts/ipag.ttf');
    Log::info('Font path' . $fontPath);
    



    // カスタムフォントの設定
    $customFont = [
        'ipag' => [
            'R'  => 'ipag.ttf',    // Regular
            'B'  => 'ipag.ttf',    // Bold
            'I'  => 'ipag.ttf',    // Italic
            'BI' => 'ipag.ttf'     // Bold Italic
        ]
    ];
    PDF::getDomPDF()->getOptions()->set('isHtml5ParserEnabled', true);
    PDF::getDomPDF()->getOptions()->set('isRemoteEnabled', true);
    PDF::getDomPDF()->getFontMetrics()->getFontFamilyManager()->registerFont('/storage/fonts/', $customFont);

    // ここまで



        
        // 画像データの準備
        $format = public_path('images/parkticket.jpg') ;
        $format_data = base64_encode(file_get_contents($format));
        // その他の表示データ
        $data = [
            'name' => $request->name , 
            'zekken' => $request->zekken , 
            'park' => $request->park,];
        // Viewのdompdf/pdf.blade.php を使ってPDFを生成
        $pdf = PDF::loadView('dompdf.pdf' , compact('format_data' , 'data'));
        // 用紙をA4タテに設定
        $pdf->setPaper('A4' , 'portrait');
        
        // 必要最低限のフォントのみをPDFへ埋め込み設定
        $pdf->setOptions([
            'isFontSubsettingEnabled' => true, // 必要最低限のフォントのみを埋め込む
            'defaultFont' => 'ipag', // デフォルトフォントを設定
        ]);

        // PDFファイルを生成してWebへ表示
        return $pdf->stream('駐車券.pdf');
    }
}
