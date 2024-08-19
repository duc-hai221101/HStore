$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('js')
    }
});

function actionDelete(event) {
    event.preventDefault();
    let urlRequest = $(this).data('url');
    let that = $(this); // giữ ngữ cảnh bên trong callback của swal
    Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!"
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                type: 'GET',
                url: urlRequest,
                success: function(data) {
                    if (data.code == 200) {
                        window.location.reload();
                        Swal.fire(
                            'Deleted!',
                            'Your file has been deleted.',
                            'success'
                        )
                    }
                },
                error: function() {
                    Swal.fire(
                        'Failed!',
                        'There was an error deleting your file.',
                        'error'
                    )
                }
            });
        }
    });
}

$(function() {
    $(document).on('click', '.action_delete', actionDelete);
});
