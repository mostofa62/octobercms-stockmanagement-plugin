<?php namespace Arkylus\Stockmanagement\Models;

use Model;

/**
 * Model
 */
class Stock extends Model
{
    use \October\Rain\Database\Traits\Validation;
    

    /**
     * @var string The database table used by the model.
     */
    public $table = 'arkylus_stockmanagement_stocks';

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];

    public $belongsTo = [
        'item' => 'Arkylus\Stockmanagement\Models\Item'
    ];

    public function getOpType(){
        return \Arkylus\Stockmanagement\Classes\Util::op_type();
    }
}
