@extends('layouts.admin')

@section('content')
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.users.update') }}" method="post">
                        @csrf
                        @method('patch')
                        <input type="hidden" name="id" value="{{ encrypt($user->id) }}">
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Name</label>
                                <input type="text" class="form-control" placeholder="Name" value="{{ $user->name }}"
                                    name="name" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Email</label>
                                <input type="email" class="form-control" placeholder="Email" value="{{ $user->email }}"
                                    name="email" required>
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
                                    value="{{ $user->dob->format('Y-m-d') }}">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Country</label>
                                <select class="form-control text-dark" name="country_id" required>
                                    <option value="">Select Country</option>
                                    @foreach ($countries as $country)
                                        <option value="{{ $country->id }}" {{ $user->country_id == $country->id ? 'selected' : '' }}>
                                            {{ $country->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Status</label>
                                <select class="form-control text-dark" name="is_active" required>
                                    <option value="1" {{ $user->is_active == 1 ? 'selected' : '' }}>Active</option>
                                    <option value="0" {{ $user->is_active == 0 ? 'selected' : '' }}>IN Active</option>
                                </select>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary float-right">UPDATE</button>
                        <a href="{{ route('admin.users') }}"
                            class="btn btn-secondary text-white btn-fw float-right mr-2">CANCEL</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
