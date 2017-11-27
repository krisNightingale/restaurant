@extends('layouts.backend')

@section('content')
    <div class="container">
        <div class="row">
            @include('admin.sidebar')

            <div class="col-md-9">
                <div class="panel panel-default">
                    <div class="panel-heading"> {{ $dish->name }}</div>
                    <div class="panel-body">

                        <a href="{{ url('/dishes') }}" title="Back"><button class="btn btn-warning btn-xs"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</button></a>
                        <a href="{{ url('/dishes/' . $dish->id . '/edit') }}" title="Edit Dish"><button class="btn btn-primary btn-xs"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</button></a>
                        {!! Form::open([
                            'method'=>'DELETE',
                            'url' => ['dishes', $dish->id],
                            'style' => 'display:inline'
                        ]) !!}
                            {!! Form::button('<i class="fa fa-trash-o" aria-hidden="true"></i> Delete', array(
                                    'type' => 'submit',
                                    'class' => 'btn btn-danger btn-xs',
                                    'title' => 'Delete Dish',
                                    'onclick'=>'return confirm("Confirm delete?")'
                            ))!!}
                        {!! Form::close() !!}
                        <br/>
                        <br/>

                        <div class="table-responsive">
                            <table class="table table-borderless">
                                <tbody>
                                    <tr>
                                        <th>ID</th><td>{{ $dish->id }}</td>
                                    </tr>
                                    <tr><th> Name </th><td> {{ $dish->name }} </td></tr>
                                    <tr><th> Price </th><td> {{ $dish->price }} </td></tr>
                                    <tr><th> Weight </th><td> {{ $dish->weight }} </td></tr>
                                    <tr><th> Category </th><td> {{ $dish->category()->first()->name }} </td></tr>
                                    <tr><th> Products </th>
                                        <td>
                                            <ul>
                                                @foreach($dish->products()->get()->all() as $product)
                                                    <li>{{ $product->name }} ({{ $product->pivot->amount }} {{$product->measure->name}})</li>
                                                @endforeach
                                            </ul>
                                        </td>
                                    </tr>
                                    <tr><th> Description </th><td> {{ $dish->description }} </td></tr>
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
