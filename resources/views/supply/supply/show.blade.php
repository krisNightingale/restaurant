@extends('layouts.backend')

@section('content')
    <div class="container">
        <div class="row">
            @include('admin.sidebar')

            <div class="col-md-9">
                <div class="panel panel-default">
                    <div class="panel-heading">Supply {{ $supply->id }}</div>
                    <div class="panel-body">

                        <a href="{{ url('/supply/supply') }}" title="Back"><button class="btn btn-warning btn-xs"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</button></a>
                        <a href="{{ url('/supply/supply/' . $supply->id . '/edit') }}" title="Edit Supply"><button class="btn btn-primary btn-xs"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</button></a>
                        {!! Form::open([
                            'method'=>'DELETE',
                            'url' => ['supply/supply', $supply->id],
                            'style' => 'display:inline'
                        ]) !!}
                            {!! Form::button('<i class="fa fa-trash-o" aria-hidden="true"></i> Delete', array(
                                    'type' => 'submit',
                                    'class' => 'btn btn-danger btn-xs',
                                    'title' => 'Delete Supply',
                                    'onclick'=>'return confirm("Confirm delete?")'
                            ))!!}
                        {!! Form::close() !!}
                        <br/>
                        <br/>

                        <div class="table-responsive">
                            <table class="table table-borderless">
                                <tbody>
                                    <tr><th>ID</th><td>{{ $supply->id }}</td></tr>
                                    <tr><th> Time </th><td> {{ $supply->time }} </td></tr>
                                    <tr><th> Price </th><td> {{ $supply->price }} </td></tr>
                                    <tr><th> Supplier </th><td> {{ $supply->supplier()->first()->name }} </td></tr>
                                    <tr><th> Products </th>
                                        <td>
                                            <ul>
                                                @foreach($supply->products()->get()->all() as $product)
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
