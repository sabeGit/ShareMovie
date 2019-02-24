<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class EmailVerification extends Mailable
{
    use Queueable, SerializesModels;

    protected $user;

    public function __construct($user)
    {
        $this->user = $user;
    }

    public function build()
    {
      return $this
          ->subject('【ShareMovie】仮登録が完了しました')
          ->view('auth.email.pre_register_mail')
          ->with([
              'token' => $this->user->email_verify_token,
              'name'  => $this->user->name,
          ]);
    }
}
