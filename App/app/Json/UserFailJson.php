<?php

declare(strict_types=1);

namespace App\Json;

trait UserFailJson
{
    private function failFileExtensionException() : array
    {
        return [
            'message' => 'file extension not applicable'
        ];
    }

    private function failS3Upload() : array
    {
        return [
            'message' => 'fail S3 upload'
        ];
    }
}
