<?php

namespace App\Http\Controllers;

use App\InventoryItem;
use App\Http\Requests\StoreItem;
use Illuminate\Http\Request;
use DB;

class InventoryItemsController extends Controller
{
    public function index()
    {
        if(request()->has('sort'))
        {
            $items = InventoryItem::where('inventory_item.Status', 'Active')
                ->join('vendor', 'vendor.VendorId', '=', 'inventory_item.VendorId')
                ->orderBy(request('sort'), 'ASC')
                ->simplePaginate(10);
        }
        else
        {
            $items = InventoryItem::where('Status', 'Active')->simplePaginate(10);
        }

        //empty string placeholder for search
        $search = "";
        
        return view('InventoryItem/index', compact('items', 'search'));
    }

    public function inactiveIndex()
    {

        if(request()->has('sort'))
        {
            $items = InventoryItem::where('inventory_item.Status', 'Inactive')
                ->whereHas('vendor', function($query){
                    $query->where('Status', 'Active');
                })
                ->join('vendor', 'vendor.VendorId', '=', 'inventory_item.VendorId')
                ->orderBy(request('sort'), 'ASC')
                ->simplePaginate(10);
        }
        else
        {
            $items = InventoryItem::where('Status', 'Inactive')
            ->whereHas('vendor', function($query){
                $query->where('Status', 'Active');
            })
            ->simplePaginate(10);
        }
        
        //empty string placeholder for search
        $search = "";

        return view('InventoryItem/inactiveIndex', compact('items', 'search'));
    }

    public function getExtraDetails()
    {
        $vendors = DB::table('vendor')->where('Status', 'Active')->get();
        if(!$vendors->count())
        {
            return redirect()->action('InventoryItemsController@index')->with('error', 'Cannot add an Inventory Item. There are no active Vendors.');
        }
        //pull divisions and categories from the divisions and categories arrays in inventory item model
        $divisions = DB::table('divisions')->get();
        $categories = DB::table('categories')->get();
        $images = DB::table('image_paths')->get();
        return view('InventoryItem/addItem', compact('vendors', 'divisions', 'categories', 'images'));
    }

    public function insertNewItem(StoreItem $request)
    {
        $item = $request->all();
        $cost = $item['cost'];
        $retail = $item['retail'];

        if(strpos($cost, '$') === false)
            $cost = '$' . $cost;
        if(strpos($retail, '$') === false)
            $retail = '$' . $retail;
        if(strpos($cost, '.') === false)
            $cost .= '.00';
        if(strpos($retail, '.') === false)
            $retail .= '.00';
        
        InventoryItem::insert(
            [
                'Description' => $item['description'],
                'Size' => $item['size'],
                'Division' => $item['division'],
                'Department' => $item['department'],
                'Category' => $item['category'],
                'ItemCost' => $cost,
                'ItemRetail' => $retail, 
                'ImageFileName' => $item['imgFileName'],
                'VendorId' => $item['vendorId']
            ]
        );

        return redirect()->action('InventoryItemsController@index');
    }

    public function editItem($id)
    {
        $item = InventoryItem::where('ItemId', $id)->firstOrFail();
        if($item->vendor->Status === 'Inactive')
        {
            return redirect()->action('InventoryItemsController@index')->with('error', 'This Inventory Item does not exist.');
        }
        $vendors = DB::table('vendor')->where('Status', 'Active')->get();

        //pull divisions and categories data from the divisions and categories tables
        $divisions = DB::table('divisions')->get();
        $categories = DB::table('categories')->get();
        $images = DB::table('image_paths')->get();

        return view('/InventoryItem/editItem', compact('item', 'vendors', 'divisions', 'categories', 'images'));
    }

    public function updateItem(StoreItem $request)
    {
        $item = $request->all();
        $cost = $item['cost'];
        $retail = $item['retail'];

        if(strpos($cost, '$') === false)
            $cost = '$' . $cost;
        if(strpos($retail, '$') === false)
            $retail = '$' . $retail;
        if(strpos($cost, '.') === false)
            $cost .= '.00';
        if(strpos($retail, '.') === false)
            $retail .= '.00';

        InventoryItem::where('ItemId', $item['itemId'])->update(
            [
                'Description' => $item['description'],
                'Size' => $item['size'],
                'Division' => $item['division'],
                'Department' => $item['department'],
                'Category' => $item['category'],
                'ItemCost' => $cost,
                'ItemRetail' => $retail, 
                'ImageFileName' => $item['imgFileName'],
                'VendorId' => $item['vendorId'],
                'Status' => $item['status']
            ]
        );
        
        return redirect()->action('InventoryItemsController@index');
    }

    public function deleteItem($id)
    {
        $item = InventoryItem::where([
            ['ItemId', $id],
            ['Status', 'Active']
        ])->firstOrFail();
        if($item->vendor->Status === "Inactive")
        {
            return redirect()->action('InventoryItemsController@index')->with('error', 'This Inventory Item does not exist.');
        }

        $item->Status = 'Inactive';
        $item->save();

        return redirect()->action('InventoryItemsController@index');
    }

    public function restoreItem($id)
    {
        //get item matching the id given or 404 if no match
        $item = InventoryItem::where([
            ['ItemId', $id],
            ['Status', 'Inactive']
        ])->firstOrFail();

        //if the vendor for this item is inactive, write noItem as true into session and 
        //   redirect to index; an alert will be shown
        if($item->vendor->Status === 'Inactive')
        {
            return redirect()->action('InventoryItemsController@index')->with('error', 'This Inventory Item does not exist.');
        }

        $item->Status = 'Active';
        $item->save();

        return redirect()->action('InventoryItemsController@index');
    }

    public function viewItem($id)
    {
        $item = InventoryItem::where('ItemId', $id)->firstOrFail();
        if($item->vendor->Status === 'Inactive')
        {
            return redirect()->action('InventoryItemsController@index')->with('error', 'This Inventory Item does not exist.');
        }

        $vendors = DB::table('vendor')->get();

        return view('/InventoryItem/viewItem', compact('item', 'vendors'));
    }
    
    public function searchActive(Request $request)
    {
        $search = $request->input('search');
        if(!$search)
        {
            return $this->index();
        }

        if(request()->has('sort'))
        {
            $items = InventoryItem::where([
                ['Description', 'like', '%' . $search . '%'],
                ['inventory_item.Status', 'Active']
            ])
            ->orWhere([
                ['ItemId', 'like', '%' . $search . '%'],
                ['inventory_item.Status', 'Active']
            ])
            ->orWhere([
                ['vendor.VendorName', 'like', '%' . $search . '%'],
                ['inventory_item.Status', 'Active']
            ])
            ->join('vendor', 'vendor.VendorId', '=', 'inventory_item.VendorId')
            ->orderBy(request('sort'), 'ASC')
            ->paginate(10);
        }
        else
        {
            $items = InventoryItem::where([
                ['Description', 'like', '%' . $search . '%'],
                ['inventory_item.Status', 'Active']
            ])
            ->orWhere([
                ['ItemId', 'like', '%' . $search . '%'],
                ['inventory_item.Status', 'Active']
            ])
            ->orWhere([
                ['vendor.VendorName', 'like', '%' . $search . '%'],
                ['inventory_item.Status', 'Active']
            ])
            ->join('vendor', 'vendor.VendorId', '=', 'inventory_item.VendorId')
            ->paginate(10);
        }
        return view('InventoryItem/index', compact('items', 'search'));
    }

    public function searchInactive(Request $request)
    {
        $search = $request->input('search');
        if(!$search)
        {
            return $this->inactiveIndex();
        }
        
        if(request()->has('sort'))
        {
            $items = InventoryItem::where([
                ['Description', 'like', '%' . $search . '%'],
                ['inventory_item.Status', 'Inactive'],
                ['vendor.Status', 'Active']
            ])
            ->orWhere([
                ['ItemId', 'like', '%' . $search . '%'],
                ['inventory_item.Status', 'Inactive'],
                ['vendor.Status', 'Active']
            ])
            ->orWhere([
                ['vendor.VendorName', 'like', '%' . $search . '%'],
                ['inventory_item.Status', 'Inactive'],
                ['vendor.Status', 'Active']
            ])
            ->join('vendor', 'vendor.VendorId', '=', 'inventory_item.VendorId')
            ->orderBy(request('sort'), 'ASC')
            ->paginate(10);
        }
        else
        {
            $items = InventoryItem::whereHas('vendor', function($query){
                $query->where('Status', 'Active');
            })
            ->where([
                ['Description', 'like', '%' . $search . '%'],
                ['inventory_item.Status', 'Inactive'],
                ['vendor.Status', 'Active']
            ])
            ->orWhere([
                ['ItemId', 'like', '%' . $search . '%'],
                ['inventory_item.Status', 'Inactive'],
                ['vendor.Status', 'Active']
            ])
            ->orWhere([
                ['vendor.VendorName', 'like', '%' . $search . '%'],
                ['inventory_item.Status', 'Inactive'],
                ['vendor.Status', 'Active']
            ])
            ->join('vendor', 'vendor.VendorId', '=', 'inventory_item.VendorId')
            ->paginate(10);
        }

        return view('InventoryItem/inactiveIndex', compact('items', 'search'));
    }
}