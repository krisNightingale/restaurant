@extends('layouts.backend')

@section('content')
    <div class="container">
        <div class="row">
            @include('admin.sidebar')

            <div class="col-md-9">
                <div class="panel panel-default">
                    <div class="panel-heading">Products</div>
                    <div class="panel-body">
                        <a href="{{ url('/products/create') }}" class="btn btn-success btn-sm" title="Add New Product">
                            <i class="fa fa-plus" aria-hidden="true"></i> Add New
                        </a>

                        {!! Form::open(['method' => 'GET', 'url' => '/products/filter', 'class' => 'navbar-form navbar-right', 'role' => 'category']) !!}
                        <div class="input-group">
                            {!! Form::select('category', $categoriesNames, null, [
                                'class' => 'form-control',
                                'value' => request('category'),
                                'name' => 'category'], $categoriesIds) !!}
                            <span class="input-group-btn">
                                <button class="btn btn-default" type="submit">
                                    <i class="fa fa-filter"></i>
                                </button>
                            </span>
                        </div>
                        {!! Form::close() !!}

                        {!! Form::open(['method' => 'GET', 'url' => '/products/filter', 'class' => 'navbar-form navbar-right', 'role' => 'measure']) !!}
                        <div class="input-group">
                            {!! Form::select('measure', $measuresNames, null, [
                                'class' => 'form-control',
                                'value' => request('measure'),
                                'name' => 'measure'], $measuresIds) !!}
                            <span class="input-group-btn">
                                <button class="btn btn-default" type="submit">
                                    <i class="fa fa-filter"></i>
                                </button>
                            </span>
                        </div>
                        {!! Form::close() !!}

                        {!! Form::open(['method' => 'GET', 'url' => '/products', 'class' => 'navbar-form navbar-right', 'role' => 'search'])  !!}
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
                                            <a href="{{url('products/sort?id=asc')}}" class="fa fa-long-arrow-up" style="text-decoration: none;"></a>
                                            <a href="{{url('products/sort?id=desc')}}" class="fa fa-long-arrow-down" style="text-decoration: none;"></a>
                                        </th>
                                        <th>Name
                                            <a href="{{url('products/sort?name=asc')}}" class="fa fa-long-arrow-up" style="text-decoration: none;"></a>
                                            <a href="{{url('products/sort?name=desc')}}" class="fa fa-long-arrow-down" style="text-decoration: none;"></a>
                                        </th>
                                        <th>Price
                                            <a href="{{url('products/sort?price=asc')}}" class="fa fa-long-arrow-up" style="text-decoration: none;"></a>
                                            <a href="{{url('products/sort?price=desc')}}" class="fa fa-long-arrow-down" style="text-decoration: none;"></a>
                                        </th>
                                        <th>Measure</th>
                                        <th>Category</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($products as $item)
                                    <tr>
                                        <td>{{ $item->id }}</td>
                                        <td>{{ $item->name }}</td><td>{{ $item->price }}</td><td>{{ $item->measure()->first()->name }}</td>
                                        <td>{{ $item->category()->first()->name }}</td>
                                        <td>
                                            <a href="{{ url('/products/' . $item->id) }}" title="View Product"><button class="btn btn-info btn-xs"><i class="fa fa-eye" aria-hidden="true"></i> View</button></a>
                                            <a href="{{ url('/products/' . $item->id . '/edit') }}" title="Edit Product"><button class="btn btn-primary btn-xs"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</button></a>
                                            {!! Form::open([
                                                'method'=>'DELETE',
                                                'url' => ['/products', $item->id],
                                                'style' => 'display:inline'
                                            ]) !!}
                                                {!! Form::button('<i class="fa fa-trash-o" aria-hidden="true"></i> Delete', array(
                                                        'type' => 'submit',
                                                        'class' => 'btn btn-danger btn-xs',
                                                        'title' => 'Delete Product',
                                                        'onclick'=>'return confirm("Confirm delete?")'
                                                )) !!}
                                            {!! Form::close() !!}
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <div class="pagination-wrapper"> {!! $products->appends(['search' => Request::get('search')])->render() !!} </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
