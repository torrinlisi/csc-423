@extends('layouts.main')

@section('content')
<div class="container mt-4 offset-md-3">
    <div class="well">
    
        <form action="{{ action('VendorsController@insertNewVendor') }}" onsubmit='return validateFormVendor()' method="post" id="addVendorForm">
            <fieldset>
        
                <legend>Add Vendor</legend>
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @elseif(session('confirmError'))
                    <div class="alert alert-danger">
                        <ul>
                            <li>{{ session('confirmError') }}</li>
                        </ul>
                    </div>
                @endif
                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label>Vendor Code</label>
                        <input type="text" class="form-control" name="vendorCode" id="vendorCode" value="{{old('vendorCode')}}" />
                    </div>
                    <div class="form-group col-md-4">
                        <label>Vendor Name</label>
                        <input type="text" class="form-control" name="vendorName" id="vendorName" value="{{old('vendorName')}}" />
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-8">
                        <label>Address</label>
                        <input type="text" class="form-control" name="vendorAddress" id="vendorAddress" value="{{old('vendorAddress')}}" />
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label>City</label>
                        <input type="text" class="form-control" name="vendorCity" id="vendorCity" value="{{old('vendorCity')}}" />
                    </div>
                    <div class="form-group col-md-2">
                        <label>State</label>
                        <select class="form-control" name="vendorState" id="vendorState" size="1" value="{{old('vendorState')}}" >
                            <option value="AL">AL</option>
                            <option value="AK">AK</option>
                            <option value="AZ">AZ</option>	
                            <option value="AR">AR</option>
                            <option value="CA">CA</option>
                            <option value="CO">CO</option>
                            <option value="CT">CT</option>
                            <option value="DC">DC</option>
                            <option value="DE">DE</option>
                            <option value="FL">FL</option>
                            <option value="GA">GA</option>
                            <option value="HI">HI</option>
                            <option value="IA">IA</option>	
                            <option value="ID">ID</option>
                            <option value="IL">IL</option>
                            <option value="IN">IN</option>
                            <option value="KS">KS</option>
                            <option value="KY">KY</option>
                            <option value="LA">LA</option>
                            <option value="MA">MA</option>
                            <option value="MD">MD</option>
                            <option value="ME">ME</option>
                            <option value="MI">MI</option>
                            <option value="MN">MN</option>
                            <option value="MO">MO</option>	
                            <option value="MS">MS</option>
                            <option value="MT">MT</option>
                            <option value="NC">NC</option>	
                            <option value="NE">NE</option>
                            <option value="NH">NH</option>
                            <option value="NJ">NJ</option>
                            <option value="NM">NM</option>			
                            <option value="NV">NV</option>
                            <option value="NY">NY</option>
                            <option value="ND">ND</option>
                            <option value="OH">OH</option>
                            <option value="OK">OK</option>
                            <option value="OR">OR</option>
                            <option value="PA">PA</option>
                            <option value="RI">RI</option>
                            <option value="SC">SC</option>
                            <option value="SD">SD</option>
                            <option value="TN">TN</option>
                            <option value="TX">TX</option>
                            <option value="UT">UT</option>
                            <option value="VT">VT</option>
                            <option value="VA">VA</option>
                            <option value="WA">WA</option>
                            <option value="WI">WI</option>	
                            <option value="WV">WV</option>
                            <option value="WY">WY</option>
                    </select>
                    </div>
                    <div class="form-group col-md-2">
                        <label>Zip</label>
                        <input type="text" class="form-control" name="vendorZip" id="vendorZip" value="{{old('vendorZip')}}" />
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label>Phone (xxx-xxx-xxxx)</label>
                        <input type="text" class="form-control" name="vendorPhone" id="vendorPhone" value="{{old('vendorPhone')}}" />
                    </div>
                    <div class="form-group col-md-4">
                        <label>Contact</label>
                        <input type="text" class="form-control" name="contactPerson" id="contactPerson" value="{{old('contactPerson')}}" />
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label>Password</label>
                        <input type="password" class="form-control" name="password" id="password" />
                </div>

                    <div class="form-group col-md-4">
                        <label>Confirm Password</label>
                        <input type="password" class="form-control" name="confirmPassword" id="confirmPassword" />
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
                <a href="/vendor/">Return to Active Vendors</a>
            </div>
        </div>
    </div>
</div>

@stop
