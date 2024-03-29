<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    //define name of table associated with model
    protected $table = 'vendor';
    //define name of primary key field for model's associated table
    protected $primaryKey = 'VendorId';
    //turn off timestamp
    public $timestamps = false;

    /**
     * gets the inventory items that belong to a vendor
     */
    public function items()
    {
        return $this->hasMany('App\InventoryItem', 'VendorId', 'VendorId');
    }

    /**
     * gets the orders that belong to a vendor
     */
    public function orders()
    {
        return $this->hasMany('App\Order', 'VendorId', 'VendorId');
    }
}