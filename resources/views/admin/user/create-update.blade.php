@extends('layouts.admin')

@section('page_title')
    {{ empty($obj->id) ? 'New User' : 'Update User' }}
@endsection

@section('breadcrumb')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-flex align-items-center justify-content-between">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('user.index') }}">User</a></li>
                        <li class="breadcrumb-item active">@yield('page_title')</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h3 class="d-flex justify-content-between align-items-center card-title">
                        @yield('page_title')
                        <a href="{{ route('user.index') }}" type="button" class="btn btn-sm btn-primary">
                            <i class="fa fa-chevron-left"></i> Back
                        </a>
                    </h3>

                    <form id="form" method="post" action="{{ route('user.create.update.post') }}" autocomplete="off"
                        novalidate="novalidate" class="custom-validation">
                        @csrf
                        <input type="hidden" name="id" value="{{ empty($obj->id) ? 0 : $obj->id }}">
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Name</label>
                                <input type="text" class="form-control" placeholder="Name"
                                    value="{{ old('name', $obj->name) }}" name="name" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Email</label>
                                <input type="email" class="form-control" placeholder="Email"
                                    value="{{ old('email', $obj->email) }}" name="email" required>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Password</label>
                                <input type="password" class="form-control" placeholder="Password" name="password"
                                    autocomplete="new-password">
                            </div>
                            <div class="form-group col-md-6">
                                <label>D.O.B</label>
                                <input type="date" class="form-control" name="dob" required
                                    value="{{ old('dob', $obj->dob) }}">
                            </div>
                        </div>
                        <button type="submit"
                            class="btn btn-primary float-right">{{ empty($obj->id) ? 'SAVE' : 'UPDATE' }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('style')
@endsection

@section('head-script')
@endsection

@section('script')
    <script>

    </script>
@endsection
