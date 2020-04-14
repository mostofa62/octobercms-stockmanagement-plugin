<?php namespace Arkylus\Stockmanagement\Controllers;

use Backend\Classes\Controller;
use BackendMenu;
use DB;

class Dashboard extends Controller
{
    public $implement = [    ];
    
    public $requiredPermissions = [
        'arkylus.stockmanagement.dashboard' 
    ];

    public function __construct()
    {
        
        parent::__construct();

        BackendMenu::setContext('Arkylus.Stockmanagement', 'dashboard');

        $this->bodyClass = 'compact-container';
        $this->pageTitle = 'arkylus.stockmanagement::lang.plugin.name';
    }

    public function index()
    {
    	
    	$this->addCss('/plugins/arkylus/stockmanagement/assets/css/stockmanagement.css', 'Arkylus.Stockmanagement');
    	//$this->addJs('/plugins/arkylus/stockmanagement/assets/lib/chartjs/Chart.min.js', 'Arkylus.Stockmanagement');

    	$totalItems = DB::table('arkylus_stockmanagement_items')->count();
    	$totalActiveItems = DB::table('arkylus_stockmanagement_items')->where('status',1)->count();
    	$totalInactiveItems = DB::table('arkylus_stockmanagement_items')->where('status',0)->count();
    	
    	
    	 //Db::select('select count(*) as totalItems from arkylus_stockmanagement_items')[0];
    	//var_dump($totalItems);
    	$this->vars['totalItems'] = $totalItems;
    	$this->vars['totalActiveItems'] = $totalActiveItems;
    	$this->vars['totalInactiveItems'] = $totalInactiveItems;

    }

    public function stockinout(){

    	///$users = Db::table('items')->simplePaginate(15);
    	//$url = \Backend::url('arkylus/stockmanagement/dashboard/onStockInOut');
    	//dd($url);

    }

    




}
