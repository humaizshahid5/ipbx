<?php

namespace App\Mail;
use Illuminate\Support\ServiceProvider;
use App\Providers;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;


class Testmail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        print_r(Config::get('mail'));
     return $this
     ->from($address = $mailConfigs->username, $name = $mailConfigs->from)
     ->subject($mailConfigs->subject)
     ->view('email');
 

      
        
    }
}
