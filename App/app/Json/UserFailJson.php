<?php

declare(strict_types=1);

namespace App\Json;

trait UserFailJson
{
    private function failFileExtensionException() : array
    {
        return [
            'messages' => 'ファイルの拡張子が不適切です'
        ];
    }

    private function failS3Upload() : array
    {
        return [
            'messages' => 'ファイルのアップロードに失敗しました'
        ];
    }
}
