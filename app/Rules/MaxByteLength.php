<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class MaxByteLength implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    protected $maxBytes;

    public function __construct($maxBytes)
    {
        $this->maxBytes = $maxBytes;
    }

    public function validate(string $attribute, mixed $value, \Closure $fail): void
    {
        // マルチバイト文字列のバイト数を計算
        if (strlen(mb_convert_encoding($value, 'SJIS', 'UTF-8')) > $this->maxBytes) {
            $fail("名前は {$this->maxBytes} 文字を超えてはいけません。");
        }
    }
}
