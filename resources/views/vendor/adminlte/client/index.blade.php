@extends('adminlte::page')

@section('title', 'Clients')

@section('content_header')
    <h1>Clients</h1>
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
            @forelse($clients as $client)
                <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>{{$client->client_name}}</td>
                    <td>{{$client?->phone}}</td>
                    <td>{{$client->email}}</td>
                    <td>{{$client->site}}</td>
                    <td>
                        <nobr>
                            <a href="{{ route('client.edit',$client->id) }}" class="btn btn-xs btn-default text-primary mx-1 shadow" title="Edit">
                                <i class="fa fa-lg fa-fw fa-pen"></i>
                            </a>

                            <form action="{{ route('client.destroy', $client->id) }}" method="POST" class="d-inline-block">
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
        {!! $clients->links() !!}
    </div>
@stop
