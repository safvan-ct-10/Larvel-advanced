@extends('layouts.admin')

@section('page_title') User @endsection

@section('content')
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h3 class="d-flex justify-content-between align-items-center card-title">
                        @yield('page_title')
                        <a href="{{ route('user.create.update') }}" type="button" class="btn btn-sm btn-primary">
                            <i class="fas fa-plus"></i> New
                        </a>
                    </h3>
                    <div class="table-responsive">
                        <table class="table table-hover" id="datatable">
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
                            <tbody id="reorder_row"></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <span class='d-none datatable_status'>{{ route('user.action', ['ID', 'STATUS']) }}</span>
@endsection

@section('style')
@endsection

@section('head-script')
@endsection

@section('script')
    <script type="text/javascript">
        jQuery(document).ready(function() {
            $('#datatable').DataTable({
                destroy: true,
                processing: true,
                serverSide: true,
                ajax: "{{ route('user.list') }}",
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex' , orderable: false, searchable: false},
                    { data: 'name', name: 'name' },
                    { data: 'email', name: 'email' },
                    { data: 'dob', name: 'dob' },
                    { data: 'dob', name: 'age' },
                    { data: 'is_active', name: 'is_active' },
                    { data: 'action', name: 'action', orderable: false, searchable: false, className: "text-center" },
                ],
                "order": [
                    [1, "asc"]
                ]
            });
        });
    </script>
@endsection
