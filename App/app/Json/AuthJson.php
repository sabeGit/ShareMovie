<?php

declare(strict_types=1);

namespace App\Json;

trait AuthJson
{
    private function successRegistered() : array
    {
        return [
            'status'  => 'created',
            'code'    => 201,
            'message' => 'success registered'
        ];
    }

    private function successLogin(string $token_) : array
    {
        return [
            'status'  => 'success',
            'code'    => 200,
            'token'   => $token_,
            'message' => 'success login'
        ];
    }

    private function failureLogin() : array
    {
        return [
            'status'  => 'failure',
            'code'    => 400,
            'message' => 'failure login'
        ];
    }

    private function successLogout() : array
    {
        return [
            'status'  => 'success',
            'code'    => 200,
            'message' => 'success logout'
        ];
    }

    private function successGetMe($data_) : array
    {
        return [
            'status'  => 'success',
            'code'    => 200,
            'data'    => $data_,
            'message' => 'success get me'
        ];
    }
}
