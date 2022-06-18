function notification(type, message) {
    if (type == "success") {
        toastr.success(message);
    } else if (type == "error") {
        toastr.error(message);
    }
}

function confirmStatusModal(id, status, datatable_id) {
    var url = "";
    if (status == 0 || status == 1 || status == 2) {
        url = $("." + datatable_id + "_status").html();
        url = url.replace(/ID/g, id);
        url = url.replace(/STATUS/g, status);
    } else {
        return false;
    }

    var text = "Are you sure, you want to disable?";
    if (status == 1) {
        text = "Are you sure, you want to enable?";
    } else if (status == 2) {
        text = "Are you sure, you want to delete?";
    }

    Swal.fire({
        title: "Confirmation",
        text: text,
        type: "warning",
        showCancelButton: true,
        confirmButtonClass: "btn btn-success mx-1",
        cancelButtonClass: "btn btn-danger mx-1",
        confirmButtonText: "Confirm",
        cancelButtonText: "Cancel",
        buttonsStyling: false,
    }).then(function(isConfirm) {
        if (isConfirm.value) {
            loader(true);

            $.ajax({
                url: url,
                type: "GET",
                cache: false,
                success: function(data) {
                    data = JSON.parse(data);
                    if (data.response == "success") {
                        notification("success", data.message, 5);
                    } else {
                        notification("error", data.message, 15);
                    }

                    $("#" + datatable_id)
                        .DataTable()
                        .draw(false);
                    loader(false);
                },
                error: function(data) {
                    errorHandler(data);
                    loader(false);
                },
            });
        }
    });

    return false;
}

function loader(type) {
    if (type) {
        $("#loaderModal").show();
    } else {
        $("#loaderModal").hide();
    }
}
