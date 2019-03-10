<?php

namespace App\Exceptions\Common;

use App\Exceptions\ApiBaseException;

class SetUpAccountException extends ApiBaseException
{
    public function __construct($message="アカウント情報を更新できませんでした。", $code=500)
    {
        parent::__construct($message, $code);
    }
}
