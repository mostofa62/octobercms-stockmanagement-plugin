<?php namespace Arkylus\Stockmanagement\Controllers;

use Backend\Classes\Controller;
use BackendMenu;
use Lang;
use DB;
use Carbon\Carbon;
use Arkylus\Stockmanagement\Models\Location;

class Userlocation extends Controller
{


	public $implement = [        
		'Backend\Behaviors\ListController'		 
	];

	public $listConfig = 'config_list.yaml';


	public function listExtendQueryBefore($query, $definition){
        
        $query->where('permissions','like','%arkylus.stockmanagement%');
        
        
       
    }

    public function __construct()
    {
        parent::__construct();
        
        //BackendMenu::setContext('Arkylus.Stockmanagement', 'items');
        BackendMenu::setContext('Arkylus.Stockmanagement', 'dashboard','manage_user_location');
        $this->pageTitle = 'arkylus.stockmanagement::lang.plugin.manage_user_location';

    }

    public function assign($id){

    	$user_location = DB::table('arkylus_stockmanagement_user_locations')->where('user_id',$id)->first();

    	$checked_ul = [];

    	if(
    		isset($user_location) 
    		&& isset($user_location->locations) 
    		
    	){
    			

    			$jsond = json_decode($user_location->locations,true);
    			if(is_array($jsond) && count($jsond) ){

    				$checked_ul = $jsond;
    			}

    	}
    	
    	
    	if (($checkedIds = post('checked')) && is_array($checkedIds) && count($checkedIds)) {

    		if(isset($user_location)){

    			DB::table('arkylus_stockmanagement_user_locations')
    			->where('user_id', $id)
    			->update([
    				'locations' => json_encode($checkedIds), 
    				'updated_at'=>Carbon::now()
    			]);


    		}else{
    			DB::table('arkylus_stockmanagement_user_locations')->insert(
				    [
				    	'locations' => json_encode($checkedIds), 
				    	'user_id' => $id,
				    	'created_at'=>Carbon::now(),
				    	'updated_at'=>Carbon::now()
				    ]
				);
    		}
    		/*
    		
    		DB::table('arkylus_stockmanagement_user_locations')->updateOrInsert(
			    ['user_id' => $id],
			    ['locations' => json_encode($checkedIds),'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now()]
			);
			*/
			return \Redirect::refresh();
    	}




    	

    	

    	$locations = Location::select('name','id','code')->get();
    	$this->vars['locaitons'] = $locations;
    	$this->vars['checked_ul'] = $checked_ul;

    }


}