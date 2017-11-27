@extends('layouts.backend')

@section('content')
    <div class="container">
        <div class="row">
            @include('admin.sidebar')

            <div class="col-md-9">
                <div class="panel panel-default">
                    <div class="panel-heading">Order {{ $order->id }}</div>
                    <div class="panel-body">

                        <a href="{{ url('/orders') }}" title="Back"><button class="btn btn-warning btn-xs"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</button></a>
                        <a href="{{ url('/orders/' . $order->id . '/edit') }}" title="Edit Order"><button class="btn btn-primary btn-xs"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</button></a>
                        {!! Form::open([
                            'method'=>'DELETE',
                            'url' => ['orders', $order->id],
                            'style' => 'display:inline'
                        ]) !!}
                            {!! Form::button('<i class="fa fa-trash-o" aria-hidden="true"></i> Delete', array(
                                    'type' => 'submit',
                                    'class' => 'btn btn-danger btn-xs',
                                    'title' => 'Delete Order',
                                    'onclick'=>'return confirm("Confirm delete?")'
                            ))!!}
                        {!! Form::close() !!}
                        <br/>
                        <br/>

                        <div class="table-responsive">
                            <table class="table table-borderless">
                                <tbody>
                                    <tr>
                                        <th>ID</th><td>{{ $order->id }}</td>
                                    </tr>
                                    <tr><th> Time </th><td> {{ $order->time }} </td></tr>
                                    <tr><th> Price </th><td> {{ $order->price }} </td></tr>
                                    <tr><th> Waiter </th><td> {{ $order->user()->first()->name }} </td></tr>
                                    <tr><th> Client </th><td> {{ $order->client()->first()->first_name }} {{ $order->client()->first()->last_name }}</td></tr>
                                    <tr><th> Dishes </th>
                                        <td>
                                            <ul>
                                                @foreach($order->dishes()->get()->all() as $dish)
                                                    <li>{{ $dish->name }} ({{ $dish->pivot->amount }})</li>
                                                @endforeach
                                            </ul>
                                        </td>
                                    </tr>
                                    <tr><th> Products </th>
                                        <td>
                                            <ul>
                                                @foreach($order->products()->get()->all() as $product)
                                                    <li>{{ $product->name }} ({{ $product->pivot->amount }} {{$product->measure->name}})</li>
                                                @endforeach
                                            </ul>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
