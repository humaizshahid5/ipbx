<?php

namespace App\Providers;
use Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;

class MailServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        if (\Schema::hasTable('mail_settings')) {
            $mail = DB::table('mail_settings')->first();
            if ($mail) //checking if table is not empty
            {
                $config = array(
                    'driver'     => $mail->driver,
                    'host'       => $mail->host,
                    'port'       => $mail->port,
                    'from_name'  => $mail->mail_from,
                    'from'       => array('address' => $mail->mail_from_address, 'name' => $mail->mail_from),
                    'encryption' => $mail->encryption,
                    'username'   => $mail->username,
                    'password'   => $mail->password,
                    'subject'   => $mail->mail_subject,
                    'sendmail'   => '/usr/sbin/sendmail -bs',
                    'pretend'    => false,
                );
                Config::set('mail', $config);
            }
        }
    }
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
