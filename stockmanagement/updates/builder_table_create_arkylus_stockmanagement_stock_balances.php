<?php namespace Arkylus\Stockmanagement\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateArkylusStockmanagementStockBalances extends Migration
{
    public function up()
    {
        if(!Schema::hasTable('arkylus_stockmanagement_stock_balances')) {
            Schema::create('arkylus_stockmanagement_stock_balances', function($table)
            {
                $table->engine = 'InnoDB';
                $table->integer('item_id');
                $table->bigInteger('balance_quantity')->default(0);
                $table->boolean('op_type')->nullable()->unsigned(false)->default(null);
                $table->timestamp('created_at')->nullable();
                $table->timestamp('updated_at')->nullable();
                $table->primary(['item_id']);
            });
        }
    }
    
    public function down()
    {
        Schema::dropIfExists('arkylus_stockmanagement_stock_balances');
    }
}
