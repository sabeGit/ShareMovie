<?php

declare(strict_types=1);

namespace App\Json;

trait AuthFailJson
{
    private function failLogin() : array
    {
        return [
            'message' => 'fail login'
        ];
    }
}
