<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MailSettings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mail_settings', function (Blueprint $table) {
            $table->id();
            $table->string('username');
            $table->string('password');
            $table->string('driver');
            $table->string('host');
            $table->string('encryption');
            $table->string('port');
            $table->string('mail_from');
            $table->string('mail_subject');
            $table->string('mail_from_address');
            
            

           
            $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
