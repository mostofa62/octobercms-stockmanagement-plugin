<?php namespace Arkylus\Stockmanagement\Models;

use Model;

/**
 * Model
 */
class StockBalance extends Model
{
    use \October\Rain\Database\Traits\Validation;
    

    /**
     * @var string The database table used by the model.
     */
    public $table = 'arkylus_stockmanagement_stock_balances';

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];
}
