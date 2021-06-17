<div class="box box-info padding-1">
    <div class="box-body">
        
        <div class="form-group">
            {{ Form::label('formato') }}
            {{ Form::text('formato', $historicokpi->formato, ['class' => 'form-control' . ($errors->has('formato') ? ' is-invalid' : ''), 'placeholder' => 'Formato']) }}
            {!! $errors->first('formato', '<div class="invalid-feedback">:message</p>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('local') }}
            {{ Form::text('local', $historicokpi->local, ['class' => 'form-control' . ($errors->has('local') ? ' is-invalid' : ''), 'placeholder' => 'Local']) }}
            {!! $errors->first('local', '<div class="invalid-feedback">:message</p>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('valor') }}
            {{ Form::text('valor', $historicokpi->valor, ['class' => 'form-control' . ($errors->has('valor') ? ' is-invalid' : ''), 'placeholder' => 'Valor']) }}
            {!! $errors->first('valor', '<div class="invalid-feedback">:message</p>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('fecha') }}
            {{ Form::text('fecha', $historicokpi->fecha, ['class' => 'form-control' . ($errors->has('fecha') ? ' is-invalid' : ''), 'placeholder' => 'Fecha']) }}
            {!! $errors->first('fecha', '<div class="invalid-feedback">:message</p>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('indicadorkpi_id') }}
            {{ Form::text('indicadorkpi_id', $historicokpi->indicadorkpi_id, ['class' => 'form-control' . ($errors->has('indicadorkpi_id') ? ' is-invalid' : ''), 'placeholder' => 'Indicadorkpi Id']) }}
            {!! $errors->first('indicadorkpi_id', '<div class="invalid-feedback">:message</p>') !!}
        </div>

    </div>
    <div class="box-footer mt20">
        <button type="submit" class="btn btn-primary">Submit</button>
    </div>
</div>