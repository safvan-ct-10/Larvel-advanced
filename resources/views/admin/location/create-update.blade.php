<div class="modal-header">
    <h5 class="modal-title">{{ empty($obj->id) ? 'New' : 'Update' }} Location</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<form id="createUpdateForm" autocomplete="off" novalidate="novalidate" class="custom-validation" action="{{ route('location.create.update.post') }}" method="POST">
    @csrf
    <input type="hidden" name="id" value="{{ empty($obj->id) ? 0 : $obj->id }}">

    <div class="modal-body">
        <div class="form-row">
            <div class="col-md-12 mb-2">
                <label>Name</label>
                <input type="text" class="form-control" placeholder="Name" name="name"
                    value="{{ $obj->name }}">
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" onclick="createUpdatePost()">{{ empty($obj->id) ? 'Save' : 'Update' }}</button>
    </div>
</form>
