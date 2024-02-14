@extends('admin.layouts.master')

@section('title', 'Relatório de Sorteios')

@section('content')

<div class="row container mx-auto p-3">
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-12">
                <div class="card-header indica-card">
                    {{ trans('admin.falta.relatorioSort') }}
                </div>
            </div>
        </div>
        <div class="card ">
            <div class="card-body ">
                @php
                use App\Helper\Money;
                @endphp

                <form action="{{ route('admin.bets.report-draws') }}" method="GET">
                    <div class="d-flex container justify-content-center flex-column align-items-center ">
                            <div class="container col-md-6">
                                <div>
                                    <label for="date">{{ trans('admin.falta.selecData') }}:</label>
                                    <input type="date" class="form-control col-md-12" name="date" id="date"
                                        value="{{ request('date') }}">
                                </div>
                                <div>
                                    <label for="type">{{ trans('admin.falta.tipo') }}:</label>
                                    <select name="type" class="form-control form-select col-md-12" id="type">
                                        <option value="geral" {{ request('type')==='geral' ? 'selected' : '' }}>{{
                                            trans('admin.falta.geral') }}</option>
                                        <option value="financeiro" {{ request('type')==='financeiro' ? 'selected' : ''
                                            }}>{{
                                            trans('admin.falta.financeiro') }}</option>
                                    </select>
                                </div>
                            </div>
                            <button type="submit" class="col-md-2 mt-3 form-control btn btn-primary">{{
                                trans('admin.falta.buscar') }}</button>
                    </div>
                </form>
            </div>
        </div>
        @endsection