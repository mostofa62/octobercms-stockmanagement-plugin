<?php namespace Arkylus\Stockmanagement\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateArkylusStockmanagementStocks2 extends Migration
{
    public function up()
    {
        Schema::table('arkylus_stockmanagement_stocks', function($table)
        {
            $table->integer('user_id')->nullable()->change();
            
        });
    }
    
    public function down()
    {
        Schema::table('arkylus_stockmanagement_stocks', function($table)
        {
            $table->integer('user_id')->nullable(false)->change();
            
        });
    }
}
