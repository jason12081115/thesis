<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRefcontracttypeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('b_refcontracttype', function (Blueprint $table) {
            $table->increments('contract_type_id');
            $table->string('contract_type_code')->default('');
            $table->string('contract_type_desc')->default('');
            $table->datetime('created_datetime')->nullable(true);
            $table->integer('created_by')->nullable(true);
            $table->datetime('modified_datetime')->nullable(true);
            $table->integer('modified_by')->nullable(true);
            $table->datetime('deleted_datetime')->nullable(true);
            $table->integer('deleted_by')->nullable(true);
            $table->boolean('is_deleted')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('refcontracttype');
    }
}
