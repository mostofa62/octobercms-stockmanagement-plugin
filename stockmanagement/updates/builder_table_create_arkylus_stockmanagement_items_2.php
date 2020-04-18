<?php namespace Arkylus\Stockmanagement\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateArkylusStockmanagementItems2 extends Migration
{
    public function up()
    {
        Schema::create('arkylus_stockmanagement_items', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->string('name', 200);
            $table->text('description')->nullable();
            $table->smallInteger('unit')->default(1);
            $table->smallInteger('status');
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->timestamp('deleted_at')->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('arkylus_stockmanagement_items');
    }
}
