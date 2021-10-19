<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class MailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('mail_settings')->insert([
            'username' => 'billing@abratel.com.br',
            'password' => 'alca1$movel',
            'driver' =>  'smtp',
            'host' =>  'smtp.ionos.com',
            'encryption' =>  'tls',
            'port' =>  '587',
            'mail_from' =>  'Abartel',
            'mail_subject' =>  'Call Report',
            'mail_from_address' =>  'info@bratel.com.br',
           
           
        ]);
    }
}
