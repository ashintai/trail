<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

// 参加者へパスワードを送信する

class PassEmail extends Mailable
{
    use Queueable, SerializesModels;

    // 送信するパスワード
    public $password;

    /**
     * Create a new message instance.
     */
    public function __construct($password)
    {
        //送信するパスワード
        $this->password = $password;
    }
    /**
     * Get the message envelope.
     * メールのタイトルの設定
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '三河高原トレイルランニングレース　パスコードのお知らせ',
        );
    }
    /**
     * Get the message content definition.
     * メール本文の設定　パスワードを入れる
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.passemail',
            with:['password' => $this->password],
        );
    }

    /**
     * Get the attachments for the message.
     * 添付ファイルの設定＝使わない
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
