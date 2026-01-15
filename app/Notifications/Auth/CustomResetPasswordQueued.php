<?php

namespace App\Notifications\Auth;

use Illuminate\Auth\Notifications\ResetPassword as ResetPasswordNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;

class CustomResetPasswordQueued extends ResetPasswordNotification implements ShouldQueue
{
    use Queueable;

    // public function __construct($token)
    // {
    //     //required to persist the token for the queue
    //     $this->token = $token;

    // }

}
