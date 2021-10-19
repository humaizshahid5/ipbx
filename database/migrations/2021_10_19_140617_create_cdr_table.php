<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCdrTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('cdr', function(Blueprint $table)
		{
			$table->increments('cdr_id');
			$table->dateTime('calldate');
			$table->string('clid', 80)->default('')->index('clid');
			$table->string('did')->nullable();
			$table->string('source', 80)->default('');
			$table->string('src', 80)->default('')->index('src');
			$table->string('dst', 80)->default('')->index('dst');
			$table->string('destination', 80)->default('');
			$table->string('dcontext', 80)->default('');
			$table->string('channel', 80)->default('')->index('channel');
			$table->string('dstchannel', 80)->default('')->index('dstchannel');
			$table->string('lastapp', 80)->default('');
			$table->string('lastdata', 80)->default('');
			$table->integer('duration')->default(0)->index('duration');
			$table->integer('billsec')->default(0)->index('billsec');
			$table->string('disposition', 45)->default('')->index('disposition');
			$table->integer('amaflags')->default(0);
			$table->string('accountcode')->default('')->index('accountcode');
			$table->string('auth_code')->nullable()->index('auth_code');
			$table->string('customer_code')->nullable()->index('customer_code');
			$table->string('pin_code')->nullable();
			$table->string('uniqueid', 32)->default('');
			$table->string('linkedid', 32)->default('');
			$table->string('sequence', 32)->default('');
			$table->string('peeraccount', 32)->default('');
			$table->enum('calltype', array('1','2','3','4'))->default('1')->comment('VitalPBX\'s call type (1-local, 2-incoming, 3-outgoing)');
			$table->string('recfile')->default('');
			$table->string('tenant', 80)->default('');
			$table->integer('trunk')->unsigned()->nullable();
			$table->index(['tenant','uniqueid'], 'tenant_2');
			$table->index(['tenant','calldate'], 'tenant');
			$table->index(['tenant','uniqueid','calltype'], 'tenant_3');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('cdr');
	}

}
