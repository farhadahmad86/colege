<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class PasswordMail extends Mailable
{
    use Queueable, SerializesModels;
    public $password;
    public $username;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($password,$username)
    {
        $this->password = $password;
        $this->username = $username;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Financtics Username & Password')->view('Emails.password');
    }
}
