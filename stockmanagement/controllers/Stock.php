<?php namespace Arkylus\Stockmanagement\Controllers;

use Backend\Classes\Controller;
use BackendMenu;
use Lang;
use DB;
use Carbon\Carbon;

class Stock extends Controller
{
    public $implement = [        'Backend\Behaviors\ListController'    ];
    
    public $listConfig = 'config_list.yaml';

    public $requiredPermissions = [
        'arkylus.stockmanagement.stock_in_out' 
    ];


    public function __construct()
    {
        parent::__construct();
        BackendMenu::setContext('Arkylus.Stockmanagement', 'dashboard', 'stock_in_out');
    }

    public function index()
    {
        //
        // Do any custom code here
        //
        //$this->vars['onStockInOutUrl'] = \Backend::url('arkylus/stockmanagement/dashboard/onStockInOut');
        $this->addCss('/plugins/arkylus/stockmanagement/assets/css/stockmanagement.css', 'Arkylus.Stockmanagement');
        $this->addJs('/plugins/arkylus/stockmanagement/assets/lib/notify.js', 'Arkylus.Stockmanagement');
        $this->addJs('/plugins/arkylus/stockmanagement/assets/js/stockmanagement.js', 'Arkylus.Stockmanagement');
        
        //$this->makeAssets();

        // Call the ListController behavior index() method
        $this->asExtension('ListController')->index();
    }
    public function onStockInOutAdjust(){

        $return = [ 
            'msg'=> Lang::get('arkylus.stockmanagement::lang.message.noinputstockmessageqty'),
            'result'=>3,            
        ];
        $rules = [
           
            'id' => 'required|numeric',
            'quantity' => 'required|numeric|min:1',
            
        ];

        $validator = \Validator::make(\Input::all(), $rules);

        if(!$validator->fails()){

            $id = input('id');
            $quantity = input('quantity');
            //first query the stock table to get product id
            $stock = DB::table('arkylus_stockmanagement_stocks')->select('item_id','quantity','op_type')->where('id', $id)
            ->first();

            $item  = $stock->item_id;
            $quantityBalance = $quantity - $stock->quantity;
            $optype = $stock->op_type;
            //dd($quantityBalance);
            //first check balaance from stock_balance table
            $stock_balance = DB::table('arkylus_stockmanagement_stock_balances')
            ->select('balance_quantity')
            ->where('item_id', $item)
            ->first();

             

            
            $balance = isset($stock_balance)?$stock_balance->balance_quantity:0;

            if(($balance-$quantityBalance) < 0 && $optype == 2){
                $return['msg'] = Lang::get('arkylus.stockmanagement::lang.message.itemnotavailable');
                $return['result'] = 2;
            }else{

                $balance = $optype == 1 ? $balance+$quantityBalance : $balance - $quantityBalance;          
                //optype = operation type 1 means in,2 means out
                DB::beginTransaction();
                try{
                    

                    DB::table('arkylus_stockmanagement_stocks')
                    ->where('id', $id)
                    ->update(['quantity'=>$quantity,'updated_at' => Carbon::now()]);
                                    
                    DB::table('arkylus_stockmanagement_stock_balances')
                    ->where('item_id', $item)
                    ->update(['balance_quantity' => $balance,'op_type'=>$optype, 'updated_at' => Carbon::now()]);

                    

                    DB::commit();

                    $msg = $optype == 1 ? Lang::get('arkylus.stockmanagement::lang.message.itemstcokedsuccefully'):Lang::get('arkylus.stockmanagement::lang.message.itemdeductedsuccefully') ;
                    $return['msg'] =  sprintf("(%d) $msg",$quantity);
                    $return['result'] = 1; 
                    $return['balance'] = $balance;  

                }catch(Exception $e){
                    DB::rollBack();
                    $return['msg'] =   Lang::get('arkylus.stockmanagement::lang.message.itemstcokedrollback');
                    $return['result'] = 0;
                }
            }   

        }

        return $return;

    }

    //delete history
    public function onStockInOutDelete(){

        $return = [ 
            'msg'=> Lang::get('arkylus.stockmanagement::lang.message.itemnotfound'),
            'result'=>3,            
        ];

        
        $id = input('id');
        $stock = DB::table('arkylus_stockmanagement_stocks')->select('item_id','quantity','op_type')->where('id', $id)
        ->first();

        if(isset($stock)){
           

            $item  = $stock->item_id;
            $quantity = $stock->quantity;
            $optype = $stock->op_type;      
            //first check balaance from stock_balance table
            $stock_balance = DB::table('arkylus_stockmanagement_stock_balances')
            ->select('balance_quantity')
            ->where('item_id', $item)
            ->first();

            $balance = isset($stock_balance)?$stock_balance->balance_quantity:0;
            if(($balance-$quantity) < 0 && $optype == 1){
                    $return['msg'] = Lang::get('arkylus.stockmanagement::lang.message.itemnotavailable');
                    $return['result'] = 2;
            }else{

                $balance = $optype == 1 ? $balance - $quantity : $balance + $quantity;
                DB::beginTransaction();
                try{
                    
                    DB::table('arkylus_stockmanagement_stocks')->where('id', $id)->delete();            
                                    
                    DB::table('arkylus_stockmanagement_stock_balances')
                    ->where('item_id', $item)
                    ->update(['balance_quantity' => $balance,'op_type'=>$optype, 'updated_at' => Carbon::now()]);

                    

                    DB::commit();
                    //$return['msg'] =  sprintf("(%d) $msg",$quantity);
                    //$return['result'] = 1;
                    return $this->listRefresh();


                }catch(Exception $e){
                    DB::rollBack();
                    $return['msg'] =   Lang::get('arkylus.stockmanagement::lang.message.itemstcokedrollback');
                    $return['result'] = 0;
                }
            }

        }

        return $return;
        
    }

}
