@extends('layouts.main')

@section('content')
<div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2 class="mt-3">All Orders</h2>
                <p>
                    <ul>
                        <li><a href='/order/newOrder'>Create New Order</a></li>
                    </ul>
                </p>
                <p>
                    <table class="table table-bordered table-hover">
                        <tr>
                            <th>OrderId</th>
                            <th>DateTimeOfOrder</th>
                            <th>Status</th>
                            <th>Add Items to Order</th>
                        </tr>
                        @foreach ($orders as $order)
                        <tr>
                            <td>{{$order->OrderId}}</td>
                            <td>{{$order->DateTimeOfOrder}}</td>
                            <td>{{$order->Status}}</td>
                            <td><a href="/order/addDetailsExistingOrder/{{$order->OrderId}}"> <i class="material-icons" style="font-size:36px;color:green;" title="Add to this Order">add_box</i></a></td>
                        </tr>
                        @endforeach
                    </table>
                    {{ $orders->links() }}
                </p>
            </div>
        </div>
    </div>
@stop