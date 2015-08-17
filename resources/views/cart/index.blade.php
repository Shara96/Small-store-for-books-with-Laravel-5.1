@extends('app')
@section('content')



<div class="title"><h1>Carts</h1></div>
<div class="col-md-9">
    <table class="table table-striped">
        <thead>

            <tr>
                <th>RowID</th>
                <th>ID</th>
                <th>Book Name</th>
                <th>Quantity</th>
                <th>Price</th>
                <th>Total</th>
                <th>Delete</th>

            </tr>

        </thead>
        <tbody>
             @foreach($cart as $carts)
            <tr>
                <td>{{$carts->rowid}}</td>
                <td>{{$carts->id}}</td>
                <td>{{$carts->name}}</td>
                <td>{{$carts->qty}}</td>
                <td>{{$carts->price}}&euro;</td>
                <td>{{$carts->subtotal}}&euro;</td>
                <td>{!! Form::open(['method' => 'DELETE','url' => ['carts', $carts->rowid]]) !!}
                {!! Form::button('<span class="glyphicon glyphicon-remove"></span>',[
                                     'class'=>'btn btn-xs btn-danger',
                                     'type'=>'submit'])
                !!}
                {!! Form::close() !!}
                </td>
            </tr>
             @endforeach
             <tr>
                    <td colspan="5" align="right"></td>
                    <td>Total:{{Cart::total()}}&euro;</td>
             </tr>
             <tr>
                <td colspan="5" align="right"> <a href="/"> <button class="btn btn-lg btn-default" type="button"><span class="glyphicon glyphicon-arrow-left">&nbsp;Continue Shopping</span></button> </a></td>
                <td>{!! Form::open(['method' => 'POST','url' => ['payment']]) !!}
                      {!! Form::button('<span class="glyphicon glyphicon-eur">&nbsp;Checkout with PayPal</span>',[
                                                         'class'=>'btn btn-lg btn-success',
                                                         'type'=>'submit']) !!}
                    {!! Form::close() !!}
                </td>
             </tr>
        </tbody>

    </table>
</div>

@stop