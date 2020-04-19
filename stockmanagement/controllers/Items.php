<?php namespace Arkylus\Stockmanagement\Controllers;

use Backend\Classes\Controller;
use BackendMenu;
use Lang;
use DB;
use Carbon\Carbon;
use Arkylus\Stockmanagement\Models\Item;

class Items extends Controller
{
    public $implement = [        'Backend\Behaviors\ListController',        'Backend\Behaviors\FormController'    ];
    
    public $listConfig = [
        'list'=>'config_list.yaml',
        'trashed' => 'config_list_trashed.yaml'
    ];
    public $formConfig = 'config_form.yaml';

    public $requiredPermissions = [
        'arkylus.stockmanagement.manage_item',        
    ];

    public function __construct()
    {
        parent::__construct();
        
        //BackendMenu::setContext('Arkylus.Stockmanagement', 'items');
        BackendMenu::setContext('Arkylus.Stockmanagement', 'dashboard','items');

    }

    public function listExtendQuery($query, $definition)
    {
       
       if ($definition == 'trashed')
       {
           $query->onlyTrashed();
       }
    }

    // added due to hover problem
    public function listInjectRowClass($record, $value)
    {
        //if ($record->trashed()) {
            return 'nolink';
        //}
    }
    /*
    public function formExtendQuery($query)
    {
        $query->withTrashed();
    }*/

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
        $this->vars['index_action'] = true;
        // Call the ListController behavior index() method
        $this->asExtension('ListController')->index();
    }

    public function trashed() {
        $this->pageTitle = trans('arkylus.stockmanagement::lang.label.item_trashed');
        //$this->bodyClass = 'slim-container';
        
        $this->makeLists();
    }

    public function onRestore() {
        if (($checkedIds = post('checked')) && is_array($checkedIds) && count($checkedIds)) {
          $restored = [];
          foreach ($checkedIds as $itemId) {
            // Thanks @alxy
            if (!$item = Item::onlyTrashed()->where('id', $itemId)) {
              continue;
            }
            $restored[$itemId] = $item->restore();
          }
          \Flash::success(trans('arkylus.stockmanagement::lang.message.restore'));
        }
        return $this->listRefresh('trashed');
    }
    /* Parmanent Delete */
    /*
    public function onDelete()
    {
        if (($checkedIds = post('checked')) && is_array($checkedIds) && count($checkedIds)) {
          foreach ($checkedIds as $itemId) {
            // Thanks @alxy
            if (!$item = Item::onlyTrashed()->where('id', $itemId)) {
              continue;
            }
            $item->forceDelete();
          }
          \Flash::success(trans('arkylus.stockmanagement::lang.message.delete'));
        }
        return $this->listRefresh('trashed');
    }
    */

    



    public function onStockInOut()
    {
        
        $return = [ 
            'msg'=> Lang::get('arkylus.stockmanagement::lang.message.noinputstockmessage'),
            'result'=>3,            
        ];
        $rules = [
            
                'item' => 'required|numeric',
                'quantity' => 'required|numeric|min:1',
                'optype' => 'required|numeric',
            
        ];

        $validator = \Validator::make(\Input::all(), $rules);
        

        
        if(!$validator->fails()){


            $item = input('item');
            $optype = input('optype');
            $quantity = input('quantity');

            //first check balaance from stock_balance table
            $stock_balance = DB::table('arkylus_stockmanagement_stock_balances')
            ->select('balance_quantity')
            ->where('item_id', $item)
            ->first();

            $balance = isset($stock_balance)?$stock_balance->balance_quantity:0;

            if(($balance-$quantity) < 0 && $optype == 2){
                $return['msg'] = Lang::get('arkylus.stockmanagement::lang.message.itemnotavailable');
                $return['result'] = 2;
            }else{
                
                $balance = $optype == 1 ? $balance+$quantity : $balance - $quantity;  
                
                DB::beginTransaction();
                try{

                    DB::table('arkylus_stockmanagement_stocks')->insert([
                        'item_id'=>$item,
                        'quantity'=>$quantity,
                        'op_type'=>$optype,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                    ]);
                    if(isset($stock_balance)){                  
                        DB::table('arkylus_stockmanagement_stock_balances')
                        ->where('item_id', $item)
                        ->update([
                            'balance_quantity' => $balance,
                            'op_type'=>$optype,
                            'updated_at' => Carbon::now(),
                        ]);

                    }else{
                        DB::table('arkylus_stockmanagement_stock_balances')->insert([
                            'item_id'=>$item,
                            'balance_quantity'=>$balance,
                            'op_type'=>$optype,
                            'created_at' => Carbon::now(),
                            'updated_at' => Carbon::now(),
                        ]);
                    }

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
}
