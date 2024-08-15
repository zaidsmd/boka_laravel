
$(document).on('click', '.__datatable-edit-modal', function () {
    if (processing === 0) {
        processing = 1;
        let html = $(this).html();
        $(this).attr('disabled', '').html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>')
        let url = $(this).data('url');
        let target = '#' + $(this).data('target');
        $.ajax({
            url: url, method: 'GET', success: response => {
                processing = 0;
                $(this).removeAttr('disabled').html(html)
                $(target).find('.modal-content').html(response);
                $(target).modal('show');
            }, error: xhr => {
                processing = 0;
                $(this).removeAttr('disabled').html(html)
                if (xhr.status !== undefined) {
                    if (xhr.status === 403) {
                        toastr.warning("Vous n'avez pas l'autorisation nécessaire pour effectuer cette action");
                        return
                    }
                }
                toastr.error('Un erreur est produit')
            }
        })
    }

})

$(document).on('click', '.sa-warning', function () {
    Swal.fire({
        title: "هل أنت متأكد؟",
        text: "لن تتمكن من العودة إلى الوراء!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "نعم، احذف!",
        cancelButtonText: "إلغاء",
        buttonsStyling: false,
        customClass: {
            confirmButton: 'btn btn-soft-danger mx-2',
            cancelButton: 'btn btn-soft-secondary mx-2',
        },


        didOpen: () => {
            $('.btn').blur()
        },
        preConfirm: async () => {
            Swal.showLoading();
            try {
                const [response] = await Promise.all([new Promise((resolve, reject) => {
                    $.ajax({
                        url: $(this).data('url'), method: 'DELETE', headers: {
                            'X-CSRF-TOKEN': __csrf_token
                        }, success: resolve, error: (_, jqXHR) => reject(_)
                    });
                })]);

                return response;
            } catch (jqXHR) {
                let errorMessage = "Une erreur s'est produite lors de la demande.";
                if (jqXHR.status !== undefined) {
                    if (jqXHR.status === 400) {
                        errorMessage = jqXHR.responseText; // Displaying the message returned by the controller
                    }
                    else if (jqXHR.status === 404) {
                        errorMessage = "La ressource n'a pas été trouvée.";
                    }
                    else if (jqXHR.status === 403) {
                        errorMessage = "Vous n'avez pas l'autorisation nécessaire pour effectuer cette action";
                    }
                }
                Swal.fire({
                    title: 'Erreur',
                    text: errorMessage,
                    icon: 'error',
                    buttonsStyling: false,
                    confirmButtonText: 'OK',
                    customClass: {
                        confirmButton: 'btn btn-soft-danger mx-2',
                    },
                });

                throw jqXHR;
            }
        }
    }).then((result) => {
        if (result.isConfirmed) {
            if (result.value) {
                Swal.fire({
                    title: 'Succès',
                    text: result.value,
                    icon: 'success',
                    buttonsStyling: false,
                    confirmButtonText: 'OK',
                    customClass: {
                        confirmButton: 'btn btn-soft-success mx-2',
                    },
                }).then(result => {
                    if (typeof table != 'undefined') {
                        table.ajax.reload();
                    } else {
                        location.reload();
                    }
                });
            } else {
                Swal.fire({
                    title: 'Erreur',
                    text: result.value,
                    icon: 'error',
                    buttonsStyling: false,
                    confirmButtonText: 'OK',
                    customClass: {
                        confirmButton: 'btn btn-soft-danger mx-2',
                    },
                });
            }
        }
    })
});
