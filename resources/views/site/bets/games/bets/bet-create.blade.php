@extends('site.layouts.master')

@section('title', 'Aposta Cadastrada')

@section('content')
    <div class="container text-center p-0 my-3">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-info">
                    <div class="card-header">
                    <h3 class="card-title">{{ trans('admin.sitePages.apost') }}</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div>
                                    @if (session('success'))
                                        <div class="alert alert-success" role="alert">
                                            {{ session('success') }}
                                        </div>
                                    @endif
                                    @if (session('error'))
                                        <div class="alert alert-danger" role="alert">
                                            {{ session('error') }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="alert alert-success" role="alert">
                        <h4 class="alert-heading">{{ trans('admin.sitePages.atencao') }} </h4>
                            <p>{{ trans('admin.sitePages.informeCod') }}  </p>
                             <h3>{{$bet->id}}</h3>
                             <hr>
                            <p class="mb-0">{{ trans('admin.sitePages.facaPag') }} </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
