<?php

namespace App\Providers;


use Config;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\DB;


class MailConfigServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {

    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        if (\Schema::hasTable('mail_settings')) {
            $mail = DB::table('mail_settings')->first();
            if ($mail) //checking if table is not empty
            {
                $mailConfigs = array(
                    'driver'     => $mail->driver,
                    'host'       => $mail->host,
                    'port'       => $mail->port,
                    'from'       => array('address' => $mail->mail_from_address, 'name' => $mail->mail_from),
                    'encryption' => $mail->encryption,
                    'username'   => $mail->username,
                    'password'   => $mail->password,
                    'subject'   => $mail->mail_subject,

                    'sendmail'   => '/usr/sbin/sendmail -bs',
                    'pretend'    => false,
                );
                Config::set('mail', $mailConfigs);
            }
             
        }
    }
}
