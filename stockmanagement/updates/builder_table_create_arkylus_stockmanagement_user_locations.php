<?php namespace Arkylus\Stockmanagement\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateArkylusStockmanagementUserLocations extends Migration
{
    public function up()
    {
        Schema::create('arkylus_stockmanagement_user_locations', function($table)
        {
            $table->engine = 'InnoDB';
            $table->integer('user_id');
            $table->text('locations')->nullable();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->primary(['user_id']);
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('arkylus_stockmanagement_user_locations');
    }
}
