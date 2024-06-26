<?php
namespace App;

// Trailプロジェクトで共通な定数を定義する
// 詠みだすには
// use App\Constants;
// $data = Constants::MAX_CATEGORY 
// とする

class Constants
{
    // 参加クラス数の設定上限数
    const MAX_CATEGORY = 12;
    // 駐車場の設定上限数
    const MAX_PARK = 8;
    // スタッフのアカウント数上限数
    const MAX_STAFF = 20;
}