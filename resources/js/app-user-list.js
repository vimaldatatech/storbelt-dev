/**
 * Page User List
 */

'use strict';

// Datatable (js)
document.addEventListener('DOMContentLoaded', function (e) {
    let borderColor, bodyBg, headingColor;

    borderColor = config.colors.borderColor;
    bodyBg = config.colors.bodyBg;
    headingColor = config.colors.headingColor;

    // Variable declaration for table
    let dt_user;
    const dt_user_table = document.querySelector('.datatables-users'),
        userView = baseUrl + 'app/user/view/account',
        // statusObj = {
        //   1: { title: 'Pending', class: 'bg-label-warning' },
        //   2: { title: 'Active', class: 'bg-label-success' },
        //   3: { title: 'Inactive', class: 'bg-label-secondary' }
        // };
        statusObj = {
            active: { title: 'Active', class: 'bg-label-success' },
            suspended: { title: 'Suspended', class: 'bg-label-warning' },
            archived: { title: 'Archived', class: 'bg-label-secondary' }
        };

    var select2 = $('.select2');
    const offCanvasForm = document.getElementById('offcanvasAddUser');

    if (select2.length) {
        var $this = select2;
        $this.wrap('<div class="position-relative"></div>').select2({
            placeholder: 'Select Country',
            dropdownParent: $this.parent()
        });
    }

    // Users datatable
    if (dt_user_table) {
        dt_user = new DataTable(dt_user_table, {
            processing: true,
            serverSide: true,
            ajax: {
                url: baseUrl + 'users/data',
                type: 'GET',
                xhrFields: {
                    withCredentials: true
                },
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            },
            columns: [
                { data: 'id' },
                { data: 'id', orderable: false, render: DataTable.render.select() },
                { data: 'first_name' },
                { data: 'role' },
                { data: 'status' },
                { data: 'action' }
            ],

            columnDefs: [
                {
                    // For Responsive
                    className: 'control',
                    searchable: false,
                    orderable: false,
                    responsivePriority: 2,
                    targets: 0,
                    render: function (data, type, full, meta) {
                        return '';
                    }
                },
                {
                    // For Checkboxes
                    targets: 1,
                    orderable: false,
                    searchable: false,
                    responsivePriority: 4,
                    checkboxes: true,
                    render: function () {
                        return '<input type="checkbox" class="dt-checkboxes form-check-input">';
                    },
                    checkboxes: {
                        selectAllRender: '<input type="checkbox" class="form-check-input">'
                    }
                },
                {
                    targets: 2,
                    responsivePriority: 3,
                    render: function (data, type, full, meta) {
                        var name = full['first_name'] + ' ' + full['last_name'];
                        var email = full['email'];
                        var image = full['avatar'];
                        var viewUrl = `/app/user/view/account/${full.id}`;
                        var output;

                        if (image) {
                            // For Avatar image
                            output =
                                '<img src="' +
                                assetsPath +
                                'img/avatars/' +
                                image +
                                '" alt="Avatar" class="rounded-circle">';
                        } else {
                            // For Avatar badge
                            var stateNum = Math.floor(Math.random() * 6);
                            var states = ['success', 'danger', 'warning', 'info', 'dark', 'primary', 'secondary'];
                            var state = states[stateNum];
                            var initials = (name.match(/\b\w/g) || []).map(char => char.toUpperCase());
                            initials = ((initials.shift() || '') + (initials.pop() || '')).toUpperCase();
                            output =
                                '<span class="avatar-initial rounded-circle bg-label-' +
                                state +
                                '">' +
                                initials +
                                '</span>';
                        }

                        // Creates full output for row
                        var row_output =
                            '<div class="d-flex justify-content-start align-items-center user-name">' +
                            '<div class="avatar-wrapper">' +
                            '<div class="avatar avatar-sm me-4">' +
                            output +
                            '</div>' +
                            '</div>' +
                            '<div class="d-flex flex-column">' +
                            '<a href="' +
                            viewUrl +
                            '" class="text-heading text-truncate">' +
                            '<span class="fw-medium">' +
                            name +
                            '</span>' +
                            '</a>' +
                            '<small>' +
                            email +
                            '</small>' +
                            '</div>' +
                            '</div>';
                        return row_output;
                    }
                },
                {
                    targets: 3,
                    render: function (data, type, full, meta) {
                        var role = (full['role'] || '').toLowerCase();
                        if (type === 'filter' || type === 'sort') {
                            return role;
                        }
                        var roleBadgeObj = {
                            super_admin: '<i class="icon-base bx bx-crown text-primary me-2"></i>',
                            admin: '<i class="icon-base bx bx-user-pin text-danger me-2"></i>',
                            company: '<i class="icon-base bx bx-buildings text-info me-2"></i>',
                            staff: '<i class="icon-base bx bx-user text-success me-2"></i>'
                        };
                        return (
                            "<span class='text-truncate d-flex align-items-center text-heading'>" +
                            (roleBadgeObj[role] || '') +
                            role.replace('_', ' ').replace(/^./, c => c.toUpperCase()) +
                            '</span>'
                        );
                    }
                },
                {
                    // User Status
                    targets: 4,
                    render: function (data, type, full, meta) {
                        const status = (full['status'] || '').toLowerCase();
                        if (type === 'filter' || type === 'sort') {
                            return status;
                        }
                        const cfg = statusObj[status] || { title: status || 'Unknown', class: 'bg-label-secondary' };

                        return '<span class="badge ' + cfg.class + '" text-capitalized>' + cfg.title + '</span>';
                    }
                },
                {
                    targets: -1,
                    title: 'Actions',
                    searchable: false,
                    orderable: false
                }
            ],
            select: {
                style: 'multi',
                selector: 'td:nth-child(2)'
            },
            order: [[2, 'desc']],
            layout: {
                topStart: {
                    rowClass: 'row mx-3 my-0 justify-content-between',
                    features: [
                        {
                            pageLength: {
                                menu: [10, 25, 50, 100],
                                text: '_MENU_'
                            }
                        }
                    ]
                },
                topEnd: {
                    features: [
                        {
                            search: {
                                placeholder: 'Search User',
                                text: '_INPUT_'
                            }
                        },
                        {
                            buttons: [
                                {
                                    extend: 'collection',
                                    className: 'btn btn-label-secondary dropdown-toggle',
                                    text: '<span class="d-flex align-items-center gap-2"><i class="icon-base bx bx-export icon-sm"></i> <span class="d-none d-sm-inline-block">Export</span></span>',
                                    buttons: [
                                        {
                                            extend: 'print',
                                            text: `<span class="d-flex align-items-center"><i class="icon-base bx bx-printer me-2"></i>Print</span>`,
                                            className: 'dropdown-item',
                                            exportOptions: {
                                                columns: [2, 3, 4],
                                                format: {
                                                    body: function (inner, coldex, rowdex) {
                                                        if (inner.length <= 0) return inner;
                                                        const el = new DOMParser().parseFromString(inner, 'text/html')
                                                            .body.childNodes;
                                                        let result = '';
                                                        el.forEach(item => {
                                                            if (
                                                                item.classList &&
                                                                item.classList.contains('user-name')
                                                            ) {
                                                                result += item.lastChild.firstChild.textContent;
                                                            } else {
                                                                result += item.textContent || item.innerText || '';
                                                            }
                                                        });
                                                        return result;
                                                    }
                                                }
                                            },
                                            customize: function (win) {
                                                win.document.body.style.color = config.colors.headingColor;
                                                win.document.body.style.borderColor = config.colors.borderColor;
                                                win.document.body.style.backgroundColor = config.colors.bodyBg;
                                                const table = win.document.body.querySelector('table');
                                                table.classList.add('compact');
                                                table.style.color = 'inherit';
                                                table.style.borderColor = 'inherit';
                                                table.style.backgroundColor = 'inherit';
                                            }
                                        },
                                        {
                                            extend: 'csv',
                                            text: `<span class="d-flex align-items-center"><i class="icon-base bx bx-file me-2"></i>Csv</span>`,
                                            className: 'dropdown-item',
                                            exportOptions: {
                                                columns: [2, 3, 4],
                                                format: {
                                                    body: function (inner, coldex, rowdex) {
                                                        if (inner.length <= 0) return inner;
                                                        const el = new DOMParser().parseFromString(inner, 'text/html')
                                                            .body.childNodes;
                                                        let result = '';
                                                        el.forEach(item => {
                                                            if (
                                                                item.classList &&
                                                                item.classList.contains('user-name')
                                                            ) {
                                                                result += item.lastChild.firstChild.textContent;
                                                            } else {
                                                                result += item.textContent || item.innerText || '';
                                                            }
                                                        });
                                                        return result;
                                                    }
                                                }
                                            }
                                        },
                                        {
                                            extend: 'excel',
                                            text: `<span class="d-flex align-items-center"><i class="icon-base bx bxs-file-export me-2"></i>Excel</span>`,
                                            className: 'dropdown-item',
                                            exportOptions: {
                                                columns: [2, 3, 4],
                                                format: {
                                                    body: function (inner, coldex, rowdex) {
                                                        if (inner.length <= 0) return inner;
                                                        const el = new DOMParser().parseFromString(inner, 'text/html')
                                                            .body.childNodes;
                                                        let result = '';
                                                        el.forEach(item => {
                                                            if (
                                                                item.classList &&
                                                                item.classList.contains('user-name')
                                                            ) {
                                                                result += item.lastChild.firstChild.textContent;
                                                            } else {
                                                                result += item.textContent || item.innerText || '';
                                                            }
                                                        });
                                                        return result;
                                                    }
                                                }
                                            }
                                        },
                                        {
                                            extend: 'pdf',
                                            text: `<span class="d-flex align-items-center"><i class="icon-base bx bxs-file-pdf me-2"></i>Pdf</span>`,
                                            className: 'dropdown-item',
                                            exportOptions: {
                                                columns: [2, 3, 4],
                                                format: {
                                                    body: function (inner, coldex, rowdex) {
                                                        if (inner.length <= 0) return inner;
                                                        const el = new DOMParser().parseFromString(inner, 'text/html')
                                                            .body.childNodes;
                                                        let result = '';
                                                        el.forEach(item => {
                                                            if (
                                                                item.classList &&
                                                                item.classList.contains('user-name')
                                                            ) {
                                                                result += item.lastChild.firstChild.textContent;
                                                            } else {
                                                                result += item.textContent || item.innerText || '';
                                                            }
                                                        });
                                                        return result;
                                                    }
                                                }
                                            }
                                        },
                                        {
                                            extend: 'copy',
                                            text: `<i class="icon-base bx bx-copy me-1"></i>Copy`,
                                            className: 'dropdown-item',
                                            exportOptions: {
                                                columns: [2, 3, 4],
                                                format: {
                                                    body: function (inner, coldex, rowdex) {
                                                        if (inner.length <= 0) return inner;
                                                        const el = new DOMParser().parseFromString(inner, 'text/html')
                                                            .body.childNodes;
                                                        let result = '';
                                                        el.forEach(item => {
                                                            if (
                                                                item.classList &&
                                                                item.classList.contains('user-name')
                                                            ) {
                                                                result += item.lastChild.firstChild.textContent;
                                                            } else {
                                                                result += item.textContent || item.innerText || '';
                                                            }
                                                        });
                                                        return result;
                                                    }
                                                }
                                            }
                                        }
                                    ]
                                },
                                ...(window.AUTH_ROLE ? [{ 
                                    text: '<i class="icon-base bx bx-plus icon-sm me-0 me-sm-2"></i><span class="d-none d-sm-inline-block">Add New Staff</span>',
                                    className: 'add-new btn btn-primary',
                                    attr: {
                                        'data-bs-toggle': 'offcanvas',
                                        'data-bs-target': '#offcanvasAddUser'
                                    }
                                }]
                                : [])
                            ]
                        }
                    ]
                },
                bottomStart: {
                    rowClass: 'row mx-3 justify-content-between',
                    features: ['info']
                },
                bottomEnd: 'paging'
            },
            language: {
                sLengthMenu: '_MENU_',
                search: '',
                searchPlaceholder: 'Search User',
                paginate: {
                    next: '<i class="icon-base bx bx-chevron-right scaleX-n1-rtl icon-18px"></i>',
                    previous: '<i class="icon-base bx bx-chevron-left scaleX-n1-rtl icon-18px"></i>',
                    first: '<i class="icon-base bx bx-chevrons-left scaleX-n1-rtl icon-18px"></i>',
                    last: '<i class="icon-base bx bx-chevrons-right scaleX-n1-rtl icon-18px"></i>'
                }
            },
            // For responsive popup
            responsive: {
                details: {
                    display: DataTable.Responsive.display.modal({
                        header: function (row) {
                            const data = row.data();
                            return 'Details of ' + data['first_name'];
                        }
                    }),
                    type: 'column',
                    renderer: function (api, rowIdx, columns) {
                        const data = columns
                            .map(function (col) {
                                return col.title !== '' // Do not show row in modal popup if title is blank (for check box)
                                    ? `<tr data-dt-row="${col.rowIndex}" data-dt-column="${col.columnIndex}">
                      <td>${col.title}:</td>
                      <td>${col.data}</td>
                    </tr>`
                                    : '';
                            })
                            .join('');

                        if (data) {
                            const div = document.createElement('div');
                            div.classList.add('table-responsive');
                            const table = document.createElement('table');
                            div.appendChild(table);
                            table.classList.add('table');
                            const tbody = document.createElement('tbody');
                            tbody.innerHTML = data;
                            table.appendChild(tbody);
                            return div;
                        }
                        return false;
                    }
                }
            },
            initComplete: function () {
                const api = this.api();

                // Helper function to create a select dropdown and append options
                /* const createFilter = (columnIndex, containerClass, selectId, defaultOptionText) => {
          const column = api.column(columnIndex);
          const select = document.createElement('select');
          select.id = selectId;
          select.className = 'form-select text-capitalize';
          select.innerHTML = `<option value="">${defaultOptionText}</option>`;
          document.querySelector(containerClass).appendChild(select);

          // Add event listener for filtering
          select.addEventListener('change', () => {
            const val = select.value ? `^${select.value}$` : '';
            column.search(val, true, false).draw();
          });

          // Populate options based on unique column data
          const uniqueData = Array.from(new Set(column.data().toArray())).sort();
          uniqueData.forEach(d => {
            const option = document.createElement('option');
            option.value = d;
            option.textContent = d;
            select.appendChild(option);
          });
        }; */

                // Role filter
                // createFilter(3, '.user_role', 'UserRole', 'Select Role');

                // Status filter
                /* const statusFilter = document.createElement('select');
        statusFilter.id = 'FilterTransaction';
        statusFilter.className = 'form-select text-capitalize';
        statusFilter.innerHTML = '<option value="">Select Status</option>';
        document.querySelector('.user_status').appendChild(statusFilter);
        statusFilter.addEventListener('change', () => {
          const val = statusFilter.value ? `^${statusFilter.value}$` : '';
          api.column(6).search(val, true, false).draw();
        });

        const statusColumn = api.column(5);
        const uniqueStatusData = Array.from(new Set(statusColumn.data().toArray())).sort();

        uniqueStatusData.forEach(d => {
          const key = (d || '').toLowerCase();
          const option = document.createElement('option');
          option.value = key; // ✅ send actual value to datatable search
          option.textContent = statusObj[key]?.title || d;
          option.className = 'text-capitalize';
          statusFilter.appendChild(option);
        }); */

                // uniqueStatusData.forEach(d => {
                //   const option = document.createElement('option');
                //   option.value = statusObj[d]?.title || d;
                //   option.textContent = statusObj[d]?.title || d;
                //   option.className = 'text-capitalize';
                //   statusFilter.appendChild(option);
                // });
            }
        });
    }

    // Delete Record
    document.addEventListener('click', function (e) {
        if (e.target.closest('.delete-record')) {
            const deleteBtn = e.target.closest('.delete-record');
            const user_id = deleteBtn.dataset.id;
            const dtrModal = document.querySelector('.dtr-bs-modal.show');

            // hide responsive modal in small screen
            if (dtrModal) {
                const bsModal = bootstrap.Modal.getInstance(dtrModal);
                bsModal.hide();
            }

            // sweetalert for confirmation of delete
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it!',
                customClass: {
                    confirmButton: 'btn btn-primary me-3',
                    cancelButton: 'btn btn-label-secondary'
                },
                buttonsStyling: false
            }).then(function (result) {
                if (result.value) {
                    // delete the data
                    fetch(`${baseUrl}users/${user_id}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            Accept: 'application/json'
                        }
                    })
                        .then(res => res.json().then(j => ({ ok: res.ok, j })))
                        .then(({ ok, j }) => {
                            if (!ok) throw j;
                            dt_user && dt_user.ajax.reload(null, false);
                            Swal.fire({
                                icon: 'success',
                                title: 'Deleted!',
                                text: 'The user has been deleted!',
                                customClass: { confirmButton: 'btn btn-success' }
                            });
                        })
                        .catch(err => {
                            Swal.fire({
                                icon: 'error',
                                title: 'Delete failed',
                                text: err.message || 'Not allowed or server error',
                                customClass: { confirmButton: 'btn btn-danger' }
                            });
                        });
                } else if (result.dismiss === Swal.DismissReason.cancel) {
                    Swal.fire({
                        title: 'Cancelled',
                        text: 'The User is not deleted!',
                        icon: 'error',
                        customClass: {
                            confirmButton: 'btn btn-success'
                        }
                    });
                }
            });
        }
    });

    // edit record
    document.addEventListener('click', function (e) {
        if (e.target.closest('.edit-record')) {
            const editBtn = e.target.closest('.edit-record');
            const user_id = editBtn.dataset.id;
            console.log(user_id);

            const dtrModal = document.querySelector('.dtr-bs-modal.show');

            // hide responsive modal in small screen
            if (dtrModal) {
                const bsModal = bootstrap.Modal.getInstance(dtrModal);
                bsModal.hide();
            }

            // changing the title of offcanvas
            document.getElementById('offcanvasAddUserLabel').innerHTML = 'Edit User';
            document.querySelector('#passwordWrap .text-muted').style.display = 'block';
            document.querySelector('#confirmPasswordWrap .text-muted').style.display = 'block';
            // get data
            // fetch(`${baseUrl}user-list/${user_id}/edit`)

            fetch(`${baseUrl}users/${user_id}`, { headers: { Accept: 'application/json' } })
                .then(res => res.json().then(j => ({ ok: res.ok, j })))
                .then(({ ok, j }) => {
                    if (!ok) throw j;

                    document.getElementById('user_id').value = j.id;
                    document.getElementById('add-user-fname').value = j.first_name;
                    document.getElementById('add-user-lname').value = j.last_name;
                    document.getElementById('add-user-email').value = j.email;

                    // If you have these fields in Blade (recommended)
                    if (document.getElementById('user-role')) document.getElementById('user-role').value = j.role || '';
                    if (document.getElementById('user-status'))
                        document.getElementById('user-status').value = j.status || 'active';
                    // if (document.getElementById('add-user-company-id'))
                    //   document.getElementById('add-user-company-id').value = j.company_id || '';

                    // Password optional on edit
                    const pw = document.getElementById('add-user-password');
                    const cnfpw = document.getElementById('add-user-password_confirmation');
                    if (pw) pw.value = '';
                    if (cnfpw) cnfpw.value = '';
                })
                .catch(err => {
                    Swal.fire({
                        icon: 'error',
                        title: 'Edit failed',
                        text: err.message || 'Not allowed or server error',
                        customClass: { confirmButton: 'btn btn-danger' }
                    });
                });
        }
    });

    // changing the title
    const addNewBtn = document.querySelector('.add-new');
    if (addNewBtn) {
        addNewBtn.addEventListener('click', function () {
            document.getElementById('user_id').value = ''; //resetting input field
            document.querySelector('#passwordWrap .text-muted').style.display = 'none';
            document.querySelector('#confirmPasswordWrap .text-muted').style.display = 'none';
            document.getElementById('offcanvasAddUserLabel').innerHTML = 'Add User';
        });
    }

    // Filter form control to default size
    // ? setTimeout used for user-list table initialization
    setTimeout(() => {
        const elementsToModify = [
            { selector: '.dt-buttons .btn', classToRemove: 'btn-secondary' },
            { selector: '.dt-search .form-control', classToRemove: 'form-control-sm' },
            { selector: '.dt-length .form-select', classToRemove: 'form-select-sm', classToAdd: 'ms-0' },
            { selector: '.dt-length', classToAdd: 'mb-md-6 mb-0' },
            { selector: '.dt-search', classToAdd: 'mb-md-6 mb-2' },
            {
                selector: '.dt-layout-end',
                classToRemove: 'justify-content-between',
                classToAdd: 'd-flex gap-md-4 justify-content-md-between justify-content-center gap-4 flex-wrap mt-0'
            },
            { selector: '.dt-layout-start', classToAdd: 'mt-0' },
            { selector: '.dt-buttons', classToAdd: 'd-flex gap-4 mb-md-0 mb-6' },
            { selector: '.dt-layout-table', classToRemove: 'row mt-2' },
            { selector: '.dt-layout-full', classToRemove: 'col-md col-12', classToAdd: 'table-responsive' }
        ];

        // Delete record
        elementsToModify.forEach(({ selector, classToRemove, classToAdd }) => {
            document.querySelectorAll(selector).forEach(element => {
                if (classToRemove) {
                    classToRemove.split(' ').forEach(className => element.classList.remove(className));
                }
                if (classToAdd) {
                    classToAdd.split(' ').forEach(className => element.classList.add(className));
                }
            });
        });
    }, 100);

    // validating form and updating user's data
    const addNewUserForm = document.getElementById('addNewUserForm');

    if (addNewUserForm) {
        const fv = FormValidation.formValidation(addNewUserForm, {
            fields: {
                fname: {
                    validators: {
                        notEmpty: { message: 'Please enter first name' },
                        stringLength: { max: 25, message: 'First Name must be less than 25 characters' }
                    }
                },
                lname: {
                    validators: {
                        notEmpty: { message: 'Please enter last name' },
                        stringLength: { max: 25, message: 'Last Name must be less than 25 characters' }
                    }
                },
                email: {
                    validators: {
                        notEmpty: { message: 'Please enter email' },
                        emailAddress: { message: 'Please enter a valid email address' }
                    }
                },
                password: {
                    validators: {
                        callback: {
                            message: 'Password must be at least 8 characters',
                            callback: function (input) {
                                const id = (document.getElementById('user_id')?.value || '').trim();
                                const val = (input.value || '').trim();

                                // Create: password required
                                if (!id) return val.length >= 8;

                                // Edit: password optional, but if provided must be 6+
                                if (id && val.length === 0) return true;
                                return val.length >= 8;
                            }
                        }
                    }
                },
                password_confirmation: {
                    validators: {
                        callback: {
                            message: 'Passwords do not match',
                            callback: function (input) {
                                const id = (document.getElementById('user_id')?.value || '').trim();
                                const password = (document.getElementById('add-user-password')?.value || '').trim();
                                const confirm = (input.value || '').trim();

                                // Create: confirm password required & must match
                                if (!id) {
                                    return confirm.length > 0 && confirm === password;
                                }

                                // Edit: both empty → valid (keep existing password)
                                if (id && password.length === 0 && confirm.length === 0) {
                                    return true;
                                }

                                // Edit: if password is provided, confirm must match
                                if (password.length > 0) {
                                    return confirm === password;
                                }

                                return true;
                            }
                        }
                    }
                },
                role: {
                    validators: {
                        notEmpty: { message: 'Please select role' }
                    }
                },
                status: {
                    validators: {
                        notEmpty: { message: 'Please select status' }
                    }
                }
            },
            plugins: {
                trigger: new FormValidation.plugins.Trigger(),
                bootstrap5: new FormValidation.plugins.Bootstrap5({
                    eleValidClass: '',
                    rowSelector: function () {
                        return '.mb-6';
                    }
                }),
                submitButton: new FormValidation.plugins.SubmitButton(),
                autoFocus: new FormValidation.plugins.AutoFocus()
            }
        }).on('core.form.valid', function () {
            const id = (document.getElementById('user_id')?.value || '').trim();
            const formData = new FormData(addNewUserForm);

            // ✅ For update use _method=PUT (because we submit via POST)
            if (id) formData.append('_method', 'PUT');

            fetch(id ? `${baseUrl}users/${id}` : `${baseUrl}users`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    Accept: 'application/json'
                },
                body: formData
            })
                .then(res => res.json().then(j => ({ ok: res.ok, j })))
                .then(({ ok, j }) => {
                    if (!ok) throw j;

                    dt_user && dt_user.ajax.reload(null, false);

                    const offcanvasInstance = bootstrap.Offcanvas.getInstance(offCanvasForm);
                    offcanvasInstance && offcanvasInstance.hide();

                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: id ? 'User updated successfully.' : 'User created successfully.',
                        customClass: { confirmButton: 'btn btn-success' }
                    });

                    // reset id after save (optional)
                    document.getElementById('user_id').value = '';
                })
                .catch(err => {
                    const offcanvasInstance = bootstrap.Offcanvas.getInstance(offCanvasForm);
                    offcanvasInstance && offcanvasInstance.hide();

                    // ✅ proper duplicate/validation message
                    let msg = 'Validation error';
                    if (err?.message) msg = err.message;

                    if (err?.errors) {
                        msg = Object.values(err.errors).flat().join('\n');
                    }

                    Swal.fire({
                        icon: 'error',
                        title: 'Save failed',
                        text: msg,
                        customClass: { confirmButton: 'btn btn-danger' }
                    });
                });
        });

        // clearing form data when offcanvas hidden
        offCanvasForm.addEventListener('hidden.bs.offcanvas', function () {
            fv.resetForm(true);
            document.getElementById('user_id').value = '';
            const pw = document.getElementById('add-user-password');
            if (pw) pw.value = '';
        });

        // ✅ revalidate company_id when role changes
        const roleEl = document.getElementById('user-role');
        if (roleEl) {
            roleEl.addEventListener('change', function () {
                fv.revalidateField('company_id');
            });
        }
    }

    // Permissions popup fetch details
    let selectedUserId = null;

    document.addEventListener('show.bs.modal', function (event) {
        document.getElementById('permission_user_id').value = '';
        const modal = event.target;

        if (modal.id !== 'addRoleModal') return;

        const trigger = event.relatedTarget;
        selectedUserId = trigger.getAttribute('data-user-id');
        document.getElementById('permission_user_id').value = selectedUserId;

        fetch(`${baseUrl}users/${selectedUserId}/permissions`).then(res => res.json()).then(data => renderPermissions(data));
    });

    function renderPermissions(data) {
        const tbody = document.getElementById('permissionTableBody');
        tbody.innerHTML = '';

        // if (data.permissions && data.permissions.length > 0) {
        if (data?.permissions && Object.keys(data.permissions).length > 0){
            Object.entries(data.permissions).forEach(([module, permissions]) => {
                if (module === 'users') {
                    return;
                }

                let row = `
                    <tr>
                        <td class="fw-medium text-heading">
                            ${titleCase(module)} Management
                        </td>
                        <td>
                            <div class="d-flex justify-content-end">
                `;

                permissions.forEach(p => {
                    const checked = data.assigned.includes(p.id) ? 'checked' : '';
                    row += `
                        <div class="form-check mb-0 me-4">
                            <input class="form-check-input"
                                type="checkbox"
                                name="permissions[]"
                                value="${p.id}"
                                id="perm_${p.id}"
                                ${checked}>
                            <label class="form-check-label" for="perm_${p.id}">
                                ${titleCase(p.action)}
                            </label>
                        </div>
                    `;
                });

                row += `
                            </div>
                        </td>
                    </tr>
                `;
                tbody.insertAdjacentHTML('beforeend', row);
            });
        }else{
            let noDataFound = `
            <tr>
                <td colspan="5" style="text-align:center;">
                    No Record Found, Please Add Permissions
                </td>
            </tr>`;
            tbody.insertAdjacentHTML('beforeend', noDataFound);
        }
    }

    function titleCase(str) {
        return str.replace(/_/g, ' ').replace(/\b\w/g, l => l.toUpperCase());
    }

    // Save User Permissions
    document.getElementById('assignUserPermission').addEventListener('submit', function (e) {
        e.preventDefault();

        const formData = new FormData(this);

        fetch(`${baseUrl}users/${selectedUserId}/permissions`, {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        })
        .then(res => res.json().then(j => ({ ok: res.ok, j })))
        .then(({ ok, j }) => {
            if (!ok) throw j;

            Swal.fire({
                icon: 'success',
                title: 'Permissions Updated',
                text: 'User permissions have been updated successfully.',
                customClass: {
                    confirmButton: 'btn btn-success'
                }
            });

            // close modal after success
            bootstrap.Modal.getInstance(
                document.getElementById('addRoleModal')
            ).hide();
        })
        .catch(err => {
            Swal.fire({
                icon: 'error',
                title: 'Update Failed',
                text: err?.message || 'You are not allowed or server error occurred.',
                customClass: {
                    confirmButton: 'btn btn-danger'
                }
            });
        });

        /* .then(res => res.json())
        .then(() => {
            bootstrap.Modal.getInstance(
                document.getElementById('addRoleModal')
            ).hide();
        }); */
    });

});
