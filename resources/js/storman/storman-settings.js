'use strict';

document.addEventListener('DOMContentLoaded', function () {

    const form = document.getElementById('formStormanSettings');
    const syncBtn = document.getElementById('syncDataBtn');

    if (!form) return;
    form.addEventListener('submit', function (e) {
        e.preventDefault();
    });

    // ==========================
    // Form Validation
    // ==========================
    const fv = FormValidation.formValidation(form, {
        fields: {
            api_url: {
                validators: {
                    notEmpty: {
                        message: 'Please enter Storage Provider API URL'
                    },
                    uri: {
                        message: 'Please enter a valid URL'
                    }
                }
            },
            token: {
                validators: {
                    notEmpty: {
                        message: 'Please enter Storage Provider API Token'
                    },
                    stringLength: {
                        min: 5,
                        message: 'Token must be at least 5 characters'
                    }
                }
            }
        },
        plugins: {
            trigger: new FormValidation.plugins.Trigger(),
            bootstrap5: new FormValidation.plugins.Bootstrap5({
                eleValidClass: '',
                rowSelector: '.fv-row'
            }),
            submitButton: new FormValidation.plugins.SubmitButton(),
            autoFocus: new FormValidation.plugins.AutoFocus()
        }
    }).on('core.form.valid', function () {

        const formData = new FormData(form);
        formData.append('_method', 'PUT');

        fetch(`${baseUrl}storman/save`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                Accept: 'application/json'
            },
            body: formData
        })
            .then(res => res.json().then(j => ({ ok: res.ok, j })))
            .then(({ ok, j }) => {
                if (!ok) throw j;

                Swal.fire({
                    icon: 'success',
                    title: 'Saved!',
                    text: 'Storage Provider settings updated successfully.',
                    customClass: {
                        confirmButton: 'btn btn-success'
                    }
                });
            })
            .catch(err => {

                let message = 'Something went wrong';

                if (err?.errors) {
                    message = Object.values(err.errors).flat().join('\n');
                } else if (err?.message) {
                    message = err.message;
                }

                Swal.fire({
                    icon: 'error',
                    title: 'Save Failed',
                    text: message,
                    customClass: {
                        confirmButton: 'btn btn-danger'
                    }
                });
            });

    });


    // ==========================
    // Sync Button Logic
    // ==========================
    if (syncBtn) {
        syncBtn.addEventListener('click', function () {

            Swal.fire({
                title: 'Are you sure?',
                text: 'This will sync Storage Provider data.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, Sync Now!',
                customClass: {
                    confirmButton: 'btn btn-primary me-3',
                    cancelButton: 'btn btn-label-secondary'
                },
                buttonsStyling: false
            }).then(function (result) {

                if (result.isConfirmed) {

                    // Disable button to prevent multiple clicks
                    syncBtn.disabled = true;

                    // Show loading Swal
                    Swal.fire({
                        title: 'Syncing...',
                        html: 'Please wait while we sync your data.',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    // Send POST request to sync API
                    const formDataN = new FormData(form);
                    fetch(`${baseUrl}storman-sync`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            Accept: 'application/json'
                        },
                        body: formDataN
                    })
                        .then(res => res.json().then(j => ({ ok: res.ok, j })))
                        .then(({ ok, j }) => {
                            if (!ok) throw j;

                            Swal.fire({
                                icon: 'success',
                                title: 'Sync Completed!',
                                text: j.message || 'Data synced successfully.',
                                customClass: {
                                    confirmButton: 'btn btn-success'
                                }
                            });
                        })
                        .catch(err => {
                            Swal.fire({
                                icon: 'error',
                                title: 'Sync Failed',
                                text: err?.message || 'Server error occurred.',
                                customClass: {
                                    confirmButton: 'btn btn-danger'
                                }
                            });
                        })
                        .finally(() => {
                            // Re-enable button after process
                            syncBtn.disabled = false;
                        });
                }

            });
        });
    }


});
