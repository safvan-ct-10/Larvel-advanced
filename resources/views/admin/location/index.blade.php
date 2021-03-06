@extends('layouts.admin')

@section('page_title')
    Location
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h3 class="d-flex justify-content-between align-items-center card-title">
                        @yield('page_title')
                        <div>
                            <button type="button" class="btn btn-primary" onclick="createUpdateForm(0)">
                                <i class="fas fa-plus"></i> New
                            </button>
                        </div>
                    </h3>

                    <div class="table-responsive">
                        <table class="table table-hover" id="datatable">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>NAME</th>
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
    <span class='d-none datatable_status'>{{ route('location.action', ['ID', 'STATUS']) }}</span>

    <div class="modal fade" id="createUpdateModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content" id="modal_content">

            </div>
        </div>
    </div>
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
                ajax: "{{ route('location.list') }}",
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex' , orderable: false, searchable: false},
                    { data: 'name', name: 'name' },
                    { data: 'action', name: 'action', orderable: false, searchable: false, className: "text-center" },
                ],
                "order": [
                    [1, "asc"]
                ]
            });
        });

        function createUpdateForm(id) {
            url = "{{ route('location.create.update', ['ID']) }}";
            url = url.replace(/ID/g, id);

            $.ajax({
                url: url,
                type: "GET",
                cache: false,
                dataType: 'json',
                success: function(data) {
                    if (data.response == "success") {
                        $('#createUpdateModal').modal('toggle');
                        $('#modal_content').html(data.message);
                    }
                },

                error: function(data) {
                    notification('error', data.responseJSON.message)
                }
            });
        }

        function createUpdatePost()
        {
            var form = $('#createUpdateForm');
            var actionUrl = form.attr('action');

            $.ajax({
                type: "POST",
                url: actionUrl,
                data: form.serialize(),
                dataType: 'json',
                success: function(data) {
                    if(data.response == 'error') {
                        notification('error', data.message)
                    }
                    if(data.response == 'success') {
                        $('#createUpdateModal').modal('toggle');
                        notification('success', data.message)
                        $("#datatable").DataTable().draw(false);
                    }
                },
                error: function(data) {
                    notification('error', data.responseJSON.message)
                }
            });
        }
    </script>
@endsection
