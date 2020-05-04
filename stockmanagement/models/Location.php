<?php namespace Arkylus\Stockmanagement\Models;

use Model;

/**
 * Model
 */
class Location extends Model
{
    use \October\Rain\Database\Traits\Validation;
    
    use \October\Rain\Database\Traits\SoftDelete;

    protected $dates = ['deleted_at'];


    /**
     * @var string The database table used by the model.
     */
    public $table = 'arkylus_stockmanagement_locations';

    /**
     * @var array Validation rules
     */
    public $rules = [
        'name' => 'required',
        'code'=>'unique:arkylus_stockmanagement_locations',
    ];
}
