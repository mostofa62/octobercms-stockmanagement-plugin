<?php namespace Arkylus\Stockmanagement\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateArkylusStockmanagementLocations extends Migration
{
    public function up()
    {
        Schema::create('arkylus_stockmanagement_locations', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->string('code', 40)->nullable();
            $table->string('name', 100);
            $table->text('details')->nullable();
            $table->boolean('is_salespoint')->default(0);
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->timestamp('deleted_at')->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('arkylus_stockmanagement_locations');
    }
}
