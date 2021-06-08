<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Companies extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('cin')->nullable();
            $table->string('company_name')->nullable();
            $table->string('email')->nullable();
            $table->string('status')->nullable();
            $table->string('age')->nullable();
            $table->string('register_number')->nullable();
            $table->string('category')->nullable();
            $table->string('sub_category')->nullable();
            $table->string('class')->nullable();
            $table->string('roc')->nullable();
            $table->string('members')->nullable();
            $table->string('wether_listed')->nullable();
            $table->string('date_of_last_agm')->nullable();
            $table->string('date_of_bal_sheet')->nullable();
            $table->string('state')->nullable();
            $table->string('district')->nullable();
            $table->string('pin')->nullable();
            $table->string('section')->nullable();
            $table->string('division')->nullable();
            $table->string('main_group')->nullable();
            $table->string('main_class')->nullable();
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
