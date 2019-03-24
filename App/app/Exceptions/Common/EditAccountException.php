<?php

namespace App\Exceptions\Common;

use App\Exceptions\ApiBaseException;

class ExtensionException extends ApiBaseException
{
    public function __construct($message="アカウント情報の更新に失敗しました", $code=500)
    {
        parent::__construct($message, $code);
    }
}
