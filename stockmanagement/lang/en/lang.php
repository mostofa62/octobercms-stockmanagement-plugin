<?php return [
    'plugin' => [
        'name' => 'Stock Management',
        'description' => 'A Simple Stock Management',
        'dashboard' => 'Dashboard',
        'items' => 'Items',
        'stockinout' => 'Adjustment',
        'stock_in_out' => 'Stock-In-Out',
    ],
    'item' => [
        'name' => 'Name',
        'description' => 'Description',
        'status' => 'Status',
        'manage' => 'Manage Item',
        'created_at' => 'Entry Date',
        'updated_at' =>'Modified Date',
    ],
    'stocks' => [
        'quantity' => 'Quantity',
        'op_type' => 'Opearation-Type',        
    ],
    'util' => [
        'active' => 'Active',
        'inactive' => 'Inactive',
        'total_items' => 'Total Items',
        'active_items' => 'Active Items',
        'inactive_items' => 'Inactive Items',
        'stock_action' => 'Stock Related Action',
        'op_in_out'=>'Select Opearation-Type',
        'op_in'=>'In',
        'op_out'=>'Out',
        'stock_in_out_save'=>'Store',         
    ],
    'label'=>[
        'stock_balance'=>'Balance',
        'from_stock_balance'=>'From Balance',
        'action_buttons'=>'Actions',
        'action_delete'=>'Remove',
        'item_trashed'=>'Trashed Items',
        'item_restore'=>'Restore Selected',
    ],
    'message'=>[
        'noinputstockmessage'=>'Please provide Quantity greated then 0 and Opearation-Type',
        'noinputstockmessageqty'=>'Please provide Quantity greated then 0',
        'itemnotavailable'=>'Item is not Available / Out of Balance',
        'itemstcokedsuccefully'=>'Item is added to stock',
        'itemdeductedsuccefully'=>'Item is removed from stock',
        'itemstcokedrollback'=>'Item does not added to stock',
        'activateitemforstock'=>'Active this item to Entry Stock',
        'itemnotfound'=>'Item not found',
        'action_delete_sure'=>'Are you sure want to remote this?',
        'restore'=>'Restored successfully',
        'delete'=>'Deleted parmanently'

    ]
];