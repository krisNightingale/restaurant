@extends('layouts.backend')

@section('content')
    <div class="container">
        <div class="row">
            @include('admin.sidebar')

            <div class="col-md-9">
                <div class="panel panel-default">
                    <div class="panel-heading">Orders</div>
                    <div class="panel-body">
                        <a href="{{ url('/orders/create') }}" class="btn btn-success btn-sm" title="Add New Order">
                            <i class="fa fa-plus" aria-hidden="true"></i> Add New
                        </a>

                        {!! Form::open(['method' => 'GET', 'url' => '/orders/filter', 'class' => 'navbar-form navbar-right', 'role' => 'user']) !!}
                        <div class="input-group">
                            {!! Form::select('user', $usersNames, null, [
                                'class' => 'form-control',
                                'value' => request('user'),
                                'name' => 'user'], $usersIds) !!}
                            <span class="input-group-btn">
                                <button class="btn btn-default" type="submit">
                                    <i class="fa fa-filter"></i>
                                </button>
                            </span>
                        </div>
                        {!! Form::close() !!}

                        {!! Form::open(['method' => 'GET', 'url' => '/orders/filter', 'class' => 'navbar-form navbar-right', 'role' => 'client']) !!}
                        <div class="input-group">
                            {!! Form::select('client', $clientsNames, null, [
                                'class' => 'form-control',
                                'value' => request('client'),
                                'name' => 'client'], $clientsIds) !!}
                            <span class="input-group-btn">
                                <button class="btn btn-default" type="submit">
                                    <i class="fa fa-filter"></i>
                                </button>
                            </span>
                        </div>
                        {!! Form::close() !!}

                        {!! Form::open(['method' => 'GET', 'url' => '/orders', 'class' => 'navbar-form navbar-right', 'role' => 'search'])  !!}
                        <div class="input-group">
                            <input type="text" class="form-control" name="search" placeholder="Search..." value="{{request('search')}}">
                            <span class="input-group-btn">
                                <button class="btn btn-default" type="submit">
                                    <i class="fa fa-search"></i>
                                </button>
                            </span>
                        </div>
                        {!! Form::close() !!}

                        <br/>
                        <br/>
                        <div class="table-responsive">
                            <table class="table table-borderless">
                                <thead>
                                    <tr>
                                        <th>ID
                                            <a href="{{url('orders/sort?id=asc')}}" class="fa fa-long-arrow-up" style="text-decoration: none;"></a>
                                            <a href="{{url('orders/sort?id=desc')}}" class="fa fa-long-arrow-down" style="text-decoration: none;"></a>
                                        </th>
                                        <th>Time
                                            <a href="{{url('orders/sort?time=asc')}}" class="fa fa-long-arrow-up" style="text-decoration: none;"></a>
                                            <a href="{{url('orders/sort?time=desc')}}" class="fa fa-long-arrow-down" style="text-decoration: none;"></a>
                                        </th>
                                        <th>Price
                                            <a href="{{url('orders/sort?price=asc')}}" class="fa fa-long-arrow-up" style="text-decoration: none;"></a>
                                            <a href="{{url('orders/sort?price=desc')}}" class="fa fa-long-arrow-down" style="text-decoration: none;"></a>
                                        </th>
                                        <th>Client</th><th>User</th><th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($orders as $item)
                                    <tr>
                                        <td>{{ $item->id }}</td>
                                        <td>{{ $item->time }}</td><td>{{ $item->price }}</td>
                                        <td>{{ $item->client()->first()->first_name}}</td>
                                        <td>{{ $item->user()->first()->name}}</td>
                                        <td>
                                            <a href="{{ url('/orders/' . $item->id) }}" title="View Order"><button class="btn btn-info btn-xs"><i class="fa fa-eye" aria-hidden="true"></i> View</button></a>
                                            <a href="{{ url('/orders/' . $item->id . '/edit') }}" title="Edit Order"><button class="btn btn-primary btn-xs"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</button></a>
                                            {!! Form::open([
                                                'method'=>'DELETE',
                                                'url' => ['/orders', $item->id],
                                                'style' => 'display:inline'
                                            ]) !!}
                                                {!! Form::button('<i class="fa fa-trash-o" aria-hidden="true"></i> Delete', array(
                                                        'type' => 'submit',
                                                        'class' => 'btn btn-danger btn-xs',
                                                        'title' => 'Delete Order',
                                                        'onclick'=>'return confirm("Confirm delete?")'
                                                )) !!}
                                            {!! Form::close() !!}
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <div class="pagination-wrapper"> {!! $orders->appends(['search' => Request::get('search')])->render() !!} </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
