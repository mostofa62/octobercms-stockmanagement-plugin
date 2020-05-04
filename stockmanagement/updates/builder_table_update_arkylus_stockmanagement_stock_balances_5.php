<?php namespace Arkylus\Stockmanagement\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateArkylusStockmanagementStockBalances5 extends Migration
{
    public function up()
    {
        Schema::table('arkylus_stockmanagement_stock_balances', function($table)
        {
            
            $table->primary(['item_id','location_id'], 'a_s_s_b_i_l_pk');
        });
    }
    
    public function down()
    {
        Schema::table('arkylus_stockmanagement_stock_balances', function($table)
        {
            $table->dropPrimary(['item_id','location_id']);
            
        });
    }
}
