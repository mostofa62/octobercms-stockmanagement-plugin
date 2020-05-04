<?php namespace Arkylus\Stockmanagement\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateArkylusStockmanagementStockBalances2 extends Migration
{
    public function up()
    {
        Schema::table('arkylus_stockmanagement_stock_balances', function($table)
        {
            $table->integer('location_id');
           
        });
    }
    
    public function down()
    {
        Schema::table('arkylus_stockmanagement_stock_balances', function($table)
        {
           
            $table->dropColumn('location_id');
            
        });
    }
}
