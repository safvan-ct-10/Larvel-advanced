@extends('layouts.admin')

@section('content')
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">

                    <h4 class="card-title">USERS</h4>
                    <a href="{{ route('admin.users.create') }}" class="btn btn-primary btn-fw float-right">ADD NEW USER</a>
                    @if (request()->route()->getName() == 'admin.users')
                        <a href="{{ route('admin.users.trashed') }}"
                            class="btn btn-primary btn-fw float-right mr-2">TRASHED USERS</a>
                    @elseif (request()->route()->getName() == 'admin.users.trashed')
                        <a href="{{ route('admin.users') }}" class="btn btn-primary btn-fw float-right mr-2">USERS</a>
                    @endif
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>NAME</th>
                                    <th>EMAIL</th>
                                    <th>D.O.B</th>
                                    <th>AGE</th>
                                    <th>STATUS</th>
                                    <th>ACTION</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $user)
                                    <tr>
                                        <td>{{ $users->firstItem() + $loop->index }}</td>{{-- $loop->iteration --}}
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ $user->dob->format('d-M-Y') }}</td>
                                        <td>{{ $user->age }}</td>
                                        <td>
                                            <span class="{{ $user->is_active == 1 ? 'text-success' : 'text-secondary' }}">
                                                {{ $user->active_text }}
                                            </span>
                                        </td>
                                        <td>
                                            @if (is_null($user->deleted_at))
                                                <a href="{{ route('admin.users.edit', encrypt($user->id)) }}"
                                                    class="btn btn-inverse-info btn-fw">Edit</a>
                                                <a href="{{ route('admin.users.delete', encrypt($user->id)) }}"
                                                    class="btn btn-inverse-warning btn-fw">Delete</a>
                                            @else
                                                <a href="{{ route('admin.users.recover-delete', encrypt($user->id)) }}"
                                                    class="btn btn-inverse-success btn-fw">Recover</a>
                                            @endif

                                            <a href="{{ route('admin.users.force-delete', encrypt($user->id)) }}"
                                                class="btn btn-inverse-danger btn-fw">Force Delete</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $users->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
