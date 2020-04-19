<?php namespace Arkylus\Stockmanagement\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateArkylusStockmanagementItems2 extends Migration
{
    public function up()
    {
        Schema::table('arkylus_stockmanagement_items', function($table)
        {
            
            $table->string('sku_unit', 100)->default('null')->change();
            
        });
    }
    
    public function down()
    {
        Schema::table('arkylus_stockmanagement_items', function($table)
        {
            $table->text('description')->default('NULL')->change();
            $table->string('sku_unit', 191)->default('NULL')->change();
            $table->timestamp('created_at')->default('NULL')->change();
            $table->timestamp('updated_at')->default('NULL')->change();
            $table->timestamp('deleted_at')->default('NULL')->change();
        });
    }
}
