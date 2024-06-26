<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;

class Player extends Authenticatable
{
    use HasFactory;

    use HasFactory;

    protected $hidden = [
        'password' ,
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // 参加クラステーブルへのリレーション設定
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // 駐車場記号へのリレーション設定
    public function park()
    {
        return $this->belongsTo(Park::class);
    }
}
