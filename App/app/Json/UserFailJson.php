<?php

declare(strict_types=1);

namespace App\Json;

trait UserFailJson
{
    private function failFileExtensionException() : array
    {
        return [
            'messages' => 'file extension not applicable'
        ];
    }

    private function failS3Upload() : array
    {
        return [
            'messages' => 'fail S3 upload'
        ];
    }
}
