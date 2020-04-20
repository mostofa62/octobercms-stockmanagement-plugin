<?php namespace Arkylus\Stockmanagement\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateArkylusStockmanagementStocks extends Migration
{
    public function up()
    {
        Schema::table('arkylus_stockmanagement_stocks', function($table)
        {
            $table->integer('user_id')->after('op_type');
            
        });
    }
    
    public function down()
    {
        Schema::table('arkylus_stockmanagement_stocks', function($table)
        {
            $table->dropColumn('user_id');
            
        });
    }
}
