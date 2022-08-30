@extends('adminlte::page')

@section('title', 'Companies')

@section('content_header')
    <h1>Companies</h1>
@stop

@section('content')
    @if(Session::has('success'))
        <div class="alert alert-success">
            {{ Session::get('success') }}
            @php
                Session::forget('success');
            @endphp
        </div>
    @endif
    <div class="table-responsive">
        <table id="table1" style="width:100%" class="table">
            <thead>
            <tr>
                <th>
                    #
                </th>
                <th>
                    Name
                </th>
                <th>
                    Phone
                </th>
                <th>
                    Email
                </th>
                <th style="width:40%">
                    Site
                </th>
                <th style="width:5%" dt-no-export="">
                    Actions
                </th>
            </tr>
            </thead>
            <tbody>
            @forelse($companies as $company)
                <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>{{$company->company_name}}</td>
                    <td>{{$company?->phone}}</td>
                    <td>{{$company->email}}</td>
                    <td>{{$company->site}}</td>
                    <td>
                        <nobr>
                            <a href="{{ route('company.edit',$company->id) }}" class="btn btn-xs btn-default text-primary mx-1 shadow" title="Edit">
                                <i class="fa fa-lg fa-fw fa-pen"></i>
                            </a>

                            <form action="{{ route('company.destroy', $company->id) }}" method="POST" class="d-inline-block">
                                @csrf
                                @method("DELETE")
                                <button class="btn btn-xs btn-default text-danger mx-1 shadow" title="Delete">
                                    <i class="fa fa-lg fa-fw fa-trash"></i>
                                </button>
                            </form>
                        </nobr>
                    </td>
                </tr>
            @empty
            @endforelse

            </tbody>
        </table>
    </div>
    <div class="mt-4">
        {!! $companies->links() !!}
    </div>
@stop
