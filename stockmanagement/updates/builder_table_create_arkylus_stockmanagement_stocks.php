<?php namespace Arkylus\Stockmanagement\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateArkylusStockmanagementStocks extends Migration
{
    public function up()
    {
        Schema::create('arkylus_stockmanagement_stocks', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->integer('item_id');
            $table->bigInteger('quantity')->default(0);
            $table->smallInteger('op_type')->nullable();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('arkylus_stockmanagement_stocks');
    }
}
