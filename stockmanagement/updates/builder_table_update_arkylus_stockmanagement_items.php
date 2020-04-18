<?php namespace Arkylus\Stockmanagement\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateArkylusStockmanagementItems extends Migration
{
    public function up()
    {
        Schema::table('arkylus_stockmanagement_items', function($table)
        {
            $table->string('sku_unit')->nullable()->after('unit');
            //$table->text('description')->default('null')->change();
            //$table->timestamp('created_at')->default('null')->change();
            //$table->timestamp('updated_at')->default('null')->change();
            //$table->timestamp('deleted_at')->default('null')->change();
        });
    }
    
    public function down()
    {
        Schema::table('arkylus_stockmanagement_items', function($table)
        {
            $table->dropColumn('sku_unit');
            $table->text('description')->default('NULL')->change();
            $table->timestamp('created_at')->default('NULL')->change();
            $table->timestamp('updated_at')->default('NULL')->change();
            $table->timestamp('deleted_at')->default('NULL')->change();
        });
    }
}
