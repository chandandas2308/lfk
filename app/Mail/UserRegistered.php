<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UserRegistered extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($admin_email, $passwd)
    {
        //
        $this->email = $admin_email;
        $this->passwd = $passwd;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
        ->from(env('MAIL_FROM_ADDRESS'))
        ->to($this->email)
        ->subject('User Registered')
        ->markdown('mails.admin-registered', ['email' => $this->email,'password'=> $this->passwd]);
    }
}
