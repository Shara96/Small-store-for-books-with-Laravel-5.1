@extends('app')

@section('content')
<h2>Payment Success!</h2>

<div class="row">
    <div class="col-md-7">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Book Name</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($cart as $carts)
                <tr>
                    <td>{{$carts->id}}</td>
                    <td>{{$carts->name}}</td>
                    <td>{{$carts->qty}}</td>
                    <td>{{$carts->price}}&euro;</td>
                    <td>{{$carts->subtotal}}&euro;</td>
                </tr>
                @endforeach
            </tbody>

        </table>

        <div class="col-xs-9">
            <div class="title"><h3>Shipping to</h3></div>
            <div class="well">
                <address>
                    <strong> {{{ $log->payer_first_name }}} {{{ $log->payer_last_name }}} </strong>
                    <p> {{{ $address['line1'] }}} </p>
                    @if(isset($address['line2']))
                    <p> {{{ $address['line1'] }}} </p>
                    @endif
                    <p>
                        {{{ $address['city'] }}},
                        {{{ $address['state'] }}}
                        {{{ $address['postal_code'] }}}
                    </p>
                    <p> {{{ $address['country_code'] }}} </p>
                </address>
            </div>
        </div>
    </div>
</div>
<div class="row">
        <div class="print">
            <a class="btn btn-primary"  href="javascript:window.print()"> <i class="glyphicon-print"></i>Print this</a>
        </div>
</div>
@stop
