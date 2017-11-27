<div class="form-group {{ $errors->has('price') ? 'has-error' : ''}}">
    {!! Form::label('price', 'Price', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::number('price', null, ['class' => 'form-control', 'required' => 'required']) !!}
        {!! $errors->first('price', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('client_id') ? 'has-error' : ''}}">
    {!! Form::label('client_id', 'Client', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::select('client_id', $clientsNames, null, ['class' => 'form-control', 'required' => 'required'], $clientsIds) !!}
        {!! $errors->first('client_id', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('user_id') ? 'has-error' : ''}}">
    {!! Form::label('user_id', 'User', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::select('user_id', $usersNames, null, ['class' => 'form-control', 'required' => 'required'], $usersIds) !!}
        {!! $errors->first('user_id', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group">
    {!! Form::label('products', 'Products', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6 table-fields2">
        @foreach($order->products()->get() as $product)
            <div class="row entry2" style="margin: 0px; padding-bottom: 5px">
                <div class="col-sm-9" style="padding-left: 0px; padding-right: 5px">
                    {!! Form::select('products[]', $productsNames, $product->id, ['class' => 'form-control'], $productsIds) !!}
                    {!! $errors->first('products', '<p class="help-block">:message</p>') !!}
                </div>
                <div class="col-sm-2" style="padding: 0px;">
                    {!! Form::text('p_amounts[]', $product->pivot->amount, ['class' => 'form-control', 'required' => 'required', 'placeholder' => 'шт/кг']) !!}
                </div>
                <div class="col-sm-1" style="padding-right: 0px; padding-left: 5px;">
                    <button class="btn btn-success btn-add inline" type="button">
                        <span class="glyphicon glyphicon-plus"></span>
                    </button>
                </div>
            </div>
        @endforeach
    </div>
</div>

<div class="form-group">
    {!! Form::label('dishes', 'Dishes', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6 table-fields1">
        @foreach($order->dishes()->get() as $dish)
            <div class="row entry1" style="margin: 0px; padding-bottom: 5px">
                <div class="col-sm-9" style="padding-left: 0px; padding-right: 5px">
                    {!! Form::select('dishes[]', $dishesNames, $dish->id, ['class' => 'form-control'], $dishesIds) !!}
                    {!! $errors->first('dishes', '<p class="help-block">:message</p>') !!}
                </div>
                <div class="col-sm-2" style="padding: 0px;">
                    {!! Form::text('d_amounts[]', $dish->pivot->amount, ['class' => 'form-control', 'required' => 'required', 'placeholder' => 'шт/кг']) !!}
                </div>
                <div class="col-sm-1" style="padding-right: 0px; padding-left: 5px;">
                    <button class="btn btn-success btn-add inline" type="button">
                        <span class="glyphicon glyphicon-plus"></span>
                    </button>
                </div>
            </div>
        @endforeach
    </div>
</div>

<div class="form-group">
    <div class="col-md-offset-4 col-md-4">
        {!! Form::submit(isset($submitButtonText) ? $submitButtonText : 'Create', ['class' => 'btn btn-primary']) !!}
    </div>
</div>

@section('scripts')
    <script type="text/javascript">
        $( document ).ready(function() {
            $(document).on('click', '.btn-add', function(e) {
                e.preventDefault();

                var tableFields = $('.table-fields1'),
                    currentEntry = $(this).parents('.entry1:first'),
                    newEntry = $(currentEntry.clone()).appendTo(tableFields);

                newEntry.find('input').val('');
                tableFields.find('.entry1:not(:last) .btn-add')
                    .removeClass('btn-add').addClass('btn-remove')
                    .removeClass('btn-success').addClass('btn-danger')
                    .html('<span class="glyphicon glyphicon-minus"></span>');
            }).on('click', '.btn-remove', function(e) {
                $(this).parents('.entry1:first').remove();

                e.preventDefault();
                return false;
            });

        });

        $( document ).ready(function() {
            $(document).on('click', '.btn-add', function(e) {
                e.preventDefault();

                var tableFields = $('.table-fields2'),
                    currentEntry = $(this).parents('.entry2:first'),
                    newEntry = $(currentEntry.clone()).appendTo(tableFields);

                newEntry.find('input').val('');
                tableFields.find('.entry2:not(:last) .btn-add')
                    .removeClass('btn-add').addClass('btn-remove')
                    .removeClass('btn-success').addClass('btn-danger')
                    .html('<span class="glyphicon glyphicon-minus"></span>');
            }).on('click', '.btn-remove', function(e) {
                $(this).parents('.entry2:first').remove();

                e.preventDefault();
                return false;
            });

        });
    </script>
@endsection