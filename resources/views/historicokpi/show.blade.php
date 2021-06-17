@extends('layouts.app')

@section('template_title')
    {{ $historicokpi->name ?? 'Show Historicokpi' }}
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="float-left">
                            <span class="card-title">Show Historicokpi</span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary" href="{{ route('historicokpis.index') }}"> Back</a>
                        </div>
                    </div>

                    <div class="card-body">
                        
                        <div class="form-group">
                            <strong>Formato:</strong>
                            {{ $historicokpi->formato }}
                        </div>
                        <div class="form-group">
                            <strong>Local:</strong>
                            {{ $historicokpi->local }}
                        </div>
                        <div class="form-group">
                            <strong>Valor:</strong>
                            {{ $historicokpi->valor }}
                        </div>
                        <div class="form-group">
                            <strong>Fecha:</strong>
                            {{ $historicokpi->fecha }}
                        </div>
                        <div class="form-group">
                            <strong>Indicadorkpi Id:</strong>
                            {{ $historicokpi->indicadorkpi_id }}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
