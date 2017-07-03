<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRotaSlotStaffTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('rota_slot_staff', function (Blueprint $table) {
            Schema::create('rota_slot_staff', function (Blueprint $table) {
                $table->engine = 'MyISAM';
                $table->increments('id');
                $table->integer('rotaid')->notNull();
                $table->smallInteger('daynumber');
                $table->integer('staffid')->nullable()->default(NULL);
                $table->string('slottype', 20)->notNull();
                $table->time('starttime')->nullable()->default(NULL);
                $table->time('endtime')->nullable()->default(NULL);
                $table->float('workhours', 4, 2)->notNull();
                $table->smallInteger('premiumminutes')->nullable()->default(NULL);
                $table->integer('roletypeid')->nullable()->default(NULL);
                $table->smallInteger('freeminutes')->nullable()->default(NULL);
                $table->smallInteger('seniorcashierminutes')->nullable()->default(NULL);
                $table->string('splitshifttimes', 11)->nullable()->default(NULL);
                $table->index(['rotaid', 'staffid'], 'rotaid');
                $table->index('daynumber', 'daynumber');
            });
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('rota_slot_staff', function (Blueprint $table) {
            Schema::drop('rota_slot_staff');
        });
    }
}
