@extends('layouts.app')

@section('template_title')
    {{ $diariokpi->name ?? 'Show Diariokpi' }}
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="float-left">
                            <span class="card-title">Show Diariokpi</span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary" href="{{ route('diariokpis.index') }}"> Back</a>
                        </div>
                    </div>

                    <div class="card-body">
                        
                        <div class="form-group">
                            <strong>Formato:</strong>
                            {{ $diariokpi->formato }}
                        </div>
                        <div class="form-group">
                            <strong>Local:</strong>
                            {{ $diariokpi->local }}
                        </div>
                        <div class="form-group">
                            <strong>Valor:</strong>
                            {{ $diariokpi->valor }}
                        </div>
                        <div class="form-group">
                            <strong>Fecha:</strong>
                            {{ $diariokpi->fecha }}
                        </div>
                        <div class="form-group">
                            <strong>Indicadorkpi Id:</strong>
                            {{ $diariokpi->indicadorkpi_id }}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
