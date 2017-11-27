<div class="form-group {{ $errors->has('name') ? 'has-error' : ''}}">
    {!! Form::label('name', 'Name', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::text('name', null, ['class' => 'form-control', 'required' => 'required']) !!}
        {!! $errors->first('name', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('price') ? 'has-error' : ''}}">
    {!! Form::label('price', 'Price', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::number('price', null, ['class' => 'form-control', 'required' => 'required']) !!}
        {!! $errors->first('price', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('weight') ? 'has-error' : ''}}">
    {!! Form::label('weight', 'Weight', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::text('weight', null, ['class' => 'form-control', 'required' => 'required']) !!}
        {!! $errors->first('weight', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('category_id') ? 'has-error' : ''}}">
    {!! Form::label('category_id', 'Category', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::select('category_id', $categoriesNames, null, ['class' => 'form-control', 'required' => 'required'], $categoriesIds) !!}
        {!! $errors->first('category_id', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('description') ? 'has-error' : ''}}">
    {!! Form::label('description', 'Description', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::textarea('description', null, ['class' => 'form-control', 'rows' => 3]) !!}
        {!! $errors->first('description', '<p class="help-block">:message</p>') !!}
    </div>
</div>
<div class="form-group">
    {!! Form::label('products', 'Products', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6 table-fields">
        @foreach($dish->products()->get() as $product)
            <div class="row entry" style="margin: 0px; padding-bottom: 5px">
            <div class="col-sm-9" style="padding-left: 0px; padding-right: 5px">
                {!! Form::select('products[]', $productsNames, $product->id, ['class' => 'form-control'], $productsIds) !!}
                {!! $errors->first('products', '<p class="help-block">:message</p>') !!}
            </div>
            <div class="col-sm-2" style="padding: 0px;">
                {!! Form::text('amounts[]', $product->pivot->amount, ['class' => 'form-control', 'required' => 'required', 'placeholder' => 'шт/кг']) !!}
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

                var tableFields = $('.table-fields'),
                    currentEntry = $(this).parents('.entry:first'),
                    newEntry = $(currentEntry.clone()).appendTo(tableFields);

                newEntry.find('input').val('');
                tableFields.find('.entry:not(:last) .btn-add')
                    .removeClass('btn-add').addClass('btn-remove')
                    .removeClass('btn-success').addClass('btn-danger')
                    .html('<span class="glyphicon glyphicon-minus"></span>');
            }).on('click', '.btn-remove', function(e) {
                $(this).parents('.entry:first').remove();

                e.preventDefault();
                return false;
            });

        });
    </script>
@endsection