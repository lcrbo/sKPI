@extends('layouts.app')

@section('template_title')
    {{ $indicadorkpi->name ?? 'Show Indicadorkpi' }}
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="float-left">
                            <span class="card-title">Show Indicadorkpi</span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary" href="{{ route('indicadorkpis.index') }}"> Back</a>
                        </div>
                    </div>

                    <div class="card-body">
                        
                        <div class="form-group">
                            <strong>Imagen:</strong>
                            {{ $indicadorkpi->imagen }}
                        </div>
                        <div class="form-group">
                            <strong>Nombre:</strong>
                            {{ $indicadorkpi->nombre }}
                        </div>
                        <div class="form-group">
                            <strong>Descripcion:</strong>
                            {{ $indicadorkpi->descripcion }}
                        </div>
                        <div class="form-group">
                            <strong>Formato:</strong>
                            {{ $indicadorkpi->formato }}
                        </div>
                        <div class="form-group">
                            <strong>Umbral1:</strong>
                            {{ $indicadorkpi->umbral1 }}
                        </div>
                        <div class="form-group">
                            <strong>Umbral2:</strong>
                            {{ $indicadorkpi->umbral2 }}
                        </div>
                        <div class="form-group">
                            <strong>Umbral3:</strong>
                            {{ $indicadorkpi->umbral3 }}
                        </div>
                        <div class="form-group">
                            <strong>Umbral4:</strong>
                            {{ $indicadorkpi->umbral4 }}
                        </div>
                        <div class="form-group">
                            <strong>Activo:</strong>
                            {{ $indicadorkpi->activo }}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
