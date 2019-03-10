<?php

namespace App\Exceptions\Common;

use App\Exceptions\ApiBaseException;

class S3Exception extends ApiBaseException
{
    public function __construct($message="S3にアップロードできませんでした。", $code=500)
    {
        parent::__construct($message, $code);
    }
}
