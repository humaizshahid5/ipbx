<?php

namespace App\Mail;
use Illuminate\Support\ServiceProvider;
use App\Providers;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;


class Mail extends Mailable
{
    use Queueable, SerializesModels;
    public $details;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($details)
    {
        $this->details = $details;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
     return $this
    ->from($address = env("username"), $name = env("from"))
    ->subject(env("subject"))
    ->view('email');

      
        
    }
}
