@extends('layouts.main')

@section('content')
<div class="container mt-4 offset-md-3">
    <div class="well">
    
        <form action="{{ action('InventoryItemsController@insertNewItem') }}" onsubmit='return validateFormItem()' method="post" id="addItemForm">
    
            <fieldset>
        
                <legend>Add Item</legend>

                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label>Description</label>
                        <input type="text" class="form-control" name="description" id="description">
                    </div>
                    <div class="form-group col-md-4">
                        <label>Size</label>
                        <input type="text" class="form-control" name="size" id="size"/>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label>Division</label>
                        <select name="division" id="division">
                        @foreach($divisions as $div):
                            <option value="{{$div->Name}}">{{$div->Name}}</option>
                        @endforeach
                        </select>
                    </div>
                    <div class="form-group col-md-4">
                        <label>Category</label>
                        <select name="category" id="category">
                        @foreach($categories as $cat):
                            <option value="{{$cat->Name}}">{{$cat->Name}}</option>
                        @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label>Department</label>
                        <input type="text" class="form-control" name="department" id="department">
                    </div>
                    <div class="form-group col-md-4">
                        <label>Cost</label>
                        <input type="text" class="form-control" name="cost" id="cost">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label>Retail</label>
                        <input type="text" class="form-control" name="retail" id="retail">
                    </div>
                    <div class="form-group col-md-4">
                        <label>Image File Name</label>
                        <input type="text" class="form-control" name="imgFileName" id="imgFileName">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-8">
                        <label>Vendor</label>
                        <select name="vendorId" id="vendorId">
                        @foreach($vendors as $vendor):
                            <option value="{{$vendor->VendorId}}">{{$vendor->VendorName}}</option>
                        @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-row">
                    <div class="btn-toolbar col-md-5">
                        <input class="btn btn-primary" onclick="this.disabled=true;this.form.submit();" type="submit" value="Submit" />
                        &nbsp;
                        <input class="btn btn-secondary" onclick="resetForms()" type="reset" value="Reset" />
                    </div>
                </div>
        
            </fieldset>
        </form>
        <div class="row mt-2">
            <div class="col-md-4">
                <a href="/item/">Return to Active Items</a>
            </div>
        </div>
    </div>
</div>

@stop
