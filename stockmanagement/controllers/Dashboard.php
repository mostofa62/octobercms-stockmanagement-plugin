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
        $totalTrashItems = DB::table('arkylus_stockmanagement_items')->where('deleted_at','<>',null)->count();
    	
    	
    	 //Db::select('select count(*) as totalItems from arkylus_stockmanagement_items')[0];
    	//var_dump($totalItems);
    	$this->vars['totalItems'] = $totalItems;
    	$this->vars['totalActiveItems'] = $totalActiveItems;
    	$this->vars['totalInactiveItems'] = $totalInactiveItems;
        $this->vars['totalTrashItems'] = $totalTrashItems;

        //High to Low Stock Items
        $htol_maxItems = \Config::get('arkylus.stockmanagement::high_to_low_maxItems', 2);
        /*
        $high_stock = DB::table('arkylus_stockmanagement_stock_balances')
            ->select('balance_quantity','name')
            ->join('arkylus_stockmanagement_items', function ($join) {
                $join->on('arkylus_stockmanagement_items.id', '=', 'arkylus_stockmanagement_stock_balances.item_id');                 
            })->orderBy('balance_quantity', 'desc')->limit($htol_maxItems)->get()->toArray();

        
        $low_stock = array_reverse(DB::table('arkylus_stockmanagement_stock_balances')
            ->select('balance_quantity','name')
            ->join('arkylus_stockmanagement_items', function ($join) {
                $join->on('arkylus_stockmanagement_items.id', '=', 'arkylus_stockmanagement_stock_balances.item_id');                 
            })->orderBy('balance_quantity', 'asc')->limit($htol_maxItems)->get()->toArray());

        $total_hls =   array_merge($high_stock,$low_stock);
        */
        $hl_query = "(SELECT (SELECT name from arkylus_stockmanagement_items WHERE id=item_id)as name,balance_quantity FROM `arkylus_stockmanagement_stock_balances` order by balance_quantity DESC limit $htol_maxItems)
UNION
(SELECT (SELECT name from arkylus_stockmanagement_items WHERE id=item_id)as name,balance_quantity FROM `arkylus_stockmanagement_stock_balances` order by balance_quantity ASC limit $htol_maxItems)";
        $total_hls = DB::select($hl_query);
        $this->vars['total_hls'] = $total_hls;
        
        //dd($total_hl);

    }

    

    

    




}
