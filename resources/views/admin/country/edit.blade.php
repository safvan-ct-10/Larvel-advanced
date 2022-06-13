@extends('layouts.admin')

@section('content')
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.country.update', $country->id) }}" method="post">
                        @csrf
                        @method('patch')
                        <input type="hidden" name="id" value="{{ encrypt($country->id) }}">
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Name</label>
                                <input type="text" class="form-control" placeholder="Name" value="{{ $country->name }}"
                                    name="name" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Code</label>
                                <input type="text" class="form-control" placeholder="Code" value="{{ $country->code }}"
                                    name="code" required>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary float-right">UPDATE</button>
                        <a href="{{ route('admin.country') }}"
                            class="btn btn-secondary text-white btn-fw float-right mr-2">CANCEL</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
