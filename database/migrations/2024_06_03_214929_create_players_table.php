<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.参加者情報のテーブル
     * 
     * 
     * name:氏名
     * email:メール
     * password:パスワード
     * remember_token:トークン（ログイン）
     * zekken:ナンバー
     * category_id:参加クラスのid
     * promise:誓約済で1
     * lock:パスワードを何回間違えたか
     * bus:バス券発行で1
     * bus_ride:バスに乗車したら1
     * park_id:駐車場のid
     * reception:受付したら1
     * dns:欠場の場合1 (Dont Start)
     * phone:連絡先電話番号。最大３つまで入力
     * group_id:グループで申し込んだ場合（メールが同じ）のid
     * comment:備考
     * 
     */
    public function up(): void
    {
         Schema::create('players', function (Blueprint $table) {
            $table->id();
            $table->string('name',100);
            $table->string('email',255);
            // $table->timestamps('email_verified_at')->nullable();
            $table->string('password',255)->nullable();
            $table->string('remember_token',255)->nullable();
            $table->string('zekken',8);
            $table->unsignedTinyInteger('category_id');
            $table->unsignedTinyInteger('promise')->nullable();
            $table->unsignedTinyInteger('lock')->nullable();
            $table->unsignedTinyInteger('bus')->nullable();
            $table->unsignedTinyInteger('bus_ride')->nullable();
            $table->unsignedTinyInteger('park_id')->nullable();
            $table->unsignedTinyInteger('reseption')->nullable();
            $table->unsignedTinyInteger('dns')->nullable();
            $table->string('phone', 255)->nullable();
            $table->bigInteger('group_id')->nullable();
            $table->string('comment',255)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('players');
    }
};
