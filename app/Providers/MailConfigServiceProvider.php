<?php

namespace App\Providers;

use App\EmailService;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;

class MailConfigServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $emailServices = EmailService::where(['active' => 1])->first();

        if ($emailServices) {
            $config = array(
                'driver'     => $emailServices->driver,
                'host'       => $emailServices->host,
                'port'       => $emailServices->port,
                'username'   => $emailServices->username,
                'password'   => $emailServices->password,
                'encryption' => $emailServices->mail_encryption,
                'from'       => array('address' => $emailServices->from_address, 'name' => $emailServices->from_name),
                'sendmail'   => '/usr/sbin/sendmail -bs',
                'pretend'    => false,
            );

            Config::set('mail', $config);
        }
    }
}
