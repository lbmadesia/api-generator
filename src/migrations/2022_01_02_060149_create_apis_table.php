<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateApisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('apis', function (Blueprint $table) {
            $table->increments('id');
            $table->string('view_permission_id', 191)->nullable();
            $table->string('name', 191)->nullable();
            $table->text('url')->nullable();
            $table->text('controller_path')->nullable();
            $table->integer('created_by')->unsigned();
            $table->integer('updated_by')->unsigned()->nullable();
            $table->timestamps();
        });
        db::table('modules')->insert(['view_permission_id'=>'manage-api','name'=>'Api Management','url'=>'admin.apis.index','created_by'=>1]);
        db::table('permissions')->insert([['name'=>'manage-api','display_name'=>'Manage api Permission'],['name'=>'create-api','display_name'=>'Create api Permission'],['name'=>'store-api','display_name'=>'Store api Permission']]);

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('apis');
    }
}
