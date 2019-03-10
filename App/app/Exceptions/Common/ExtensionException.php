<?php

namespace App\Exceptions\Common;

use App\Exceptions\ApiBaseException;

class ExtensionException extends ApiBaseException
{
    public function __construct($message="不正な拡張子です。", $code=400)
    {
        parent::__construct($message, $code);
    }
}
