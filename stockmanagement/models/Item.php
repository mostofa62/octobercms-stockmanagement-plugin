<?php namespace Arkylus\Stockmanagement\Models;

use Model;

/**
 * Model
 */
class Item extends Model
{
    use \October\Rain\Database\Traits\Validation;
    
    use \October\Rain\Database\Traits\SoftDelete;

    protected $dates = ['deleted_at'];


    /**
     * @var string The database table used by the model.
     */
    public $table = 'arkylus_stockmanagement_items';

    /**
     * @var array Validation rules
     */
    public $rules = [
        'name' => 'required',
        'unit'=> 'required',
        'sku_unit'=>'unique:arkylus_stockmanagement_items',
    ];

    public $hasOne = [
        'stock_balance' => 'Arkylus\Stockmanagement\Models\StockBalance'
    ];

    public $attachOne = [
        'photo'=> 'System\Models\File'
    ];

    public function listUnits($fieldName, $value, $formData)
    {
        return \Arkylus\Stockmanagement\Classes\Util::item_unit();
    }

    
}
