<div class="form-group {{ $errors->has('time') ? 'has-error' : ''}}">
    {!! Form::label('time', 'Time', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::datetimeLocal( 'time', date('Y-m-d H:i:s'), ['class' => 'form-control', 'required' => 'required']) !!}
        {!! $errors->first('time', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('price') ? 'has-error' : ''}}">
    {!! Form::label('price', 'Price', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::number('price', null, ['class' => 'form-control', 'required' => 'required']) !!}
        {!! $errors->first('price', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('supplier_id') ? 'has-error' : ''}}">
    {!! Form::label('supplier_id', 'Supplier', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::select('supplier_id', $suppliersNames, null, ['class' => 'form-control', 'required' => 'required'], $suppliersIds) !!}
        {!! $errors->first('supplier_id', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('is_paid') ? 'has-error' : ''}}">
    {!! Form::label('is_paid', 'Is Paid', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        <div class="checkbox">
    <label>{!! Form::radio('is_paid', '1') !!} Yes</label>
</div>
<div class="checkbox">
    <label>{!! Form::radio('is_paid', '0', true) !!} No</label>
</div>
        {!! $errors->first('is_paid', '<p class="help-block">:message</p>') !!}
    </div>
</div>
<div class="form-group">
    {!! Form::label('products', 'Products', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6 table-fields">
        <div class="row entry" style="margin: 0px; padding-bottom: 5px">
            <div class="col-sm-9" style="padding-left: 0px; padding-right: 5px">
                {!! Form::select('products[]', $productsNames, null, ['class' => 'form-control'], $productsIds) !!}
                {!! $errors->first('products', '<p class="help-block">:message</p>') !!}
            </div>
            <div class="col-sm-2" style="padding: 0px;">
                {!! Form::text('amounts[]', null, ['class' => 'form-control', 'required' => 'required', 'placeholder' => 'шт/кг']) !!}
            </div>
            <div class="col-sm-1" style="padding-right: 0px; padding-left: 5px;">
                <button class="btn btn-success btn-add inline" type="button">
                    <span class="glyphicon glyphicon-plus"></span>
                </button>
            </div>
        </div>
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