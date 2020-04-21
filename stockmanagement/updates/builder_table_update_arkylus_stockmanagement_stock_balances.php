<?php namespace Arkylus\Stockmanagement\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateArkylusStockmanagementStockBalances extends Migration
{
    public function up()
    {
        Schema::table('arkylus_stockmanagement_stock_balances', function($table)
        {
            $table->boolean('op_type')->nullable()->unsigned(false)->default(null)->change();
            
        });
    }
    
    public function down()
    {
        Schema::table('arkylus_stockmanagement_stock_balances', function($table)
        {
            $table->smallInteger('op_type')->nullable()->unsigned(false)->default(NULL)->change();
            
        });
    }
}
