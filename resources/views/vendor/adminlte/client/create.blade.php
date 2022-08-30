@extends('adminlte::page')

@section('title', 'Create New Client')

@section('content_header')
    <h1>Create New Client</h1>
@stop

@section('content')

    @if($errors)
        @foreach ($errors->all() as $error)
            <div>{{ $error }}</div>
        @endforeach
    @endif

    <div>
        <form action="{{ route('client.store') }}" method="POST">
            @csrf
            <x-adminlte-input name="client_name" label="Client name" fgroup-class="col-md-6" placeholder="Client name"
                              label-class="text-lightblue" enable-old-support required>
                <x-slot name="prependSlot">
                    <div class="input-group-text">
                        <i class="fas fa-user text-lightblue"></i>
                    </div>
                </x-slot>
            </x-adminlte-input>

            <x-adminlte-input name="email" label="Email" fgroup-class="col-md-6" placeholder="Email"
                              label-class="text-lightblue" enable-old-support required>
                <x-slot name="prependSlot">
                    <div class="input-group-text">
                        <i class="fas fa-envelope text-lightblue"></i>
                    </div>
                </x-slot>
            </x-adminlte-input>

            <x-adminlte-input name="phone" label="Phone" fgroup-class="col-md-6" placeholder="Phone"
                              label-class="text-lightblue" enable-old-support required>
                <x-slot name="prependSlot">
                    <div class="input-group-text">
                        <i class="fas fa-phone text-lightblue"></i>
                    </div>
                </x-slot>
            </x-adminlte-input>

            <x-adminlte-input name="site" label="Web site" fgroup-class="col-md-6" placeholder="Web site"
                              label-class="text-lightblue" enable-old-support required>
                <x-slot name="prependSlot">
                    <div class="input-group-text">
                        <i class="fas fa-link text-lightblue"></i>
                    </div>
                </x-slot>
            </x-adminlte-input>

            <x-adminlte-select2 id="sel2Vehicle" name="company_id[]" label="Companies" label-class="text-lightblue"
                                igroup-size="lg" data-placeholder="Select an option..." fgroup-class="col-md-6" enable-old-support multiple>
                <x-slot name="prependSlot">
                    <div class="input-group-text bg-gradient-info">
                        <i class="fas fa-home"></i>
                    </div>
                </x-slot>
                @foreach($companies as $company)
                    <option value="{{$company->id}}">{{$company->company_name}}</option>
                @endforeach
            </x-adminlte-select2>

            <x-adminlte-button style="margin-left: 7px;" type="submit" label="Submit" theme="primary" icon="fas fa-lg fa-save"/>

        </form>
    </div>

@stop
