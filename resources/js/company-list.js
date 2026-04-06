/**
 * DataTables Basic
 */

'use strict';

let fv, offCanvasEl;
document.addEventListener('DOMContentLoaded', function (e) {
    // init function
    const dt_basic_table = document.querySelector('.datatables-basic');
    let dt_basic;
    if (dt_basic_table) {
        let tableTitle = document.createElement('h5');
        tableTitle.classList.add('card-title', 'mb-0', 'text-md-start', 'text-center');
        tableTitle.innerHTML = 'Company List';
        dt_basic = new DataTable(dt_basic_table, {
            ajax: baseUrl + 'company/data',
            columns: [
                { data: 'id' },
                { data: 'id', orderable: false, render: DataTable.render.select() },
                { data: 'id' },
                { data: 'name' },
                { data: 'email' },
                { data: 'phone' },
                { data: 'status' },
                { data: 'id' }
            ],
            columnDefs: [
                {
                    // For Responsive
                    className: 'control',
                    orderable: false,
                    searchable: false,
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
                    responsivePriority: 3,
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
                    searchable: false,
                    visible: false
                },
                {
                    targets: 4, // Email column
                    render: function(data, type, full) {
                        const email = full['email'] || '-';
                        return `<a href="mailto:${email}">${email}</a>`;
                    }
                },
                {
                    targets: 5, // Phone column
                    render: function(data, type, full) {
                        const phone = full['phone'] || '-';
                        return `<a href="tel:${phone}">${phone}</a>`;
                    }
                },
                {
                    // Label
                    targets: -2,
                    render: function (data, type, full, meta) {
                        const statusNumber = full.status;
                        const statuses = {
                            active: { title: 'Active', class: 'bg-label-success' },
                            suspended: { title: 'Suspended', class: 'bg-label-danger' }
                        };

                        if (typeof statuses[statusNumber] === 'undefined') {
                            return data;
                        }

                        return `<span class="badge ${statuses[statusNumber].class}">${statuses[statusNumber].title}</span>`;
                    }
                },
                {
                    // Actions
                    targets: -1,
                    title: 'Actions',
                    orderable: false,
                    searchable: false,
                    className: 'd-flex align-items-center',
                    render: function (data, type, full, meta) {
                        let buttons = '';

                        // Delete button
                        if (window.userPermissions.delete) {
                            buttons += '<button title="Delete" class="btn btn-sm btn-icon delete-record" data-id="' + full['id'] + '"><i class="icon-base bx bx-trash icon-22px"></i></button>';
                        }else{
                            buttons += '-';
                        }

                        // Edit button
                        if (window.userPermissions.edit) {
                            buttons += `<a href="${baseUrl}company-list/${full.id}/edit" title="Edit" class="btn btn-sm btn-icon"><i class="icon-base bx bx-edit icon-22px"></i></a>`;
                        }else{
                            buttons += '-';
                        }
                        buttons += '<button title="Permissions" class="btn btn-sm btn-icon user-permission-modal" data-user-id="' + full['user_id'] + '" data-bs-toggle="modal" data-bs-target="#addRoleModal">' + '<i class="icon-base bx bx-universal-access icon-24px"></i></button>';
                        return buttons;
                    }
                }
            ],
            select: {
                style: 'multi',
                selector: 'td:nth-child(2)'
            },
            order: [[2, 'desc']],
            layout: {
                top2Start: {
                    rowClass: 'row card-header flex-column flex-md-row pb-0',
                    features: [tableTitle]
                },
                top2End: {
                    features: [
                        {
                            buttons: [
                                {
                                    extend: 'collection',
                                    className: 'btn btn-label-primary dropdown-toggle me-4',
                                    text: '<span class="d-flex align-items-center gap-2"><i class="icon-base bx bx-export me-sm-1"></i> <span class="d-none d-sm-inline-block">Export</span></span>',
                                    buttons: [
                                        {
                                            extend: 'print',
                                            text: `<span class="d-flex align-items-center"><i class="icon-base bx bx-printer me-1"></i>Print</span>`,
                                            className: 'dropdown-item',
                                            exportOptions: {
                                                columns: [3, 4, 5],
                                                format: {
                                                    body: function (inner, coldex, rowdex) {
                                                        if (inner.length <= 0) return inner;

                                                        // Check if inner is HTML content
                                                        if (inner.indexOf('<') > -1) {
                                                            const parser = new DOMParser();
                                                            const doc = parser.parseFromString(inner, 'text/html');

                                                            // Get all text content
                                                            let text = '';

                                                            // Handle specific elements
                                                            const userNameElements = doc.querySelectorAll('.user-name');
                                                            if (userNameElements.length > 0) {
                                                                userNameElements.forEach(el => {
                                                                    // Get text from nested structure
                                                                    const nameText =
                                                                        el.querySelector('.fw-medium')?.textContent ||
                                                                        el.querySelector('.d-block')?.textContent ||
                                                                        el.textContent;
                                                                    text += nameText.trim() + ' ';
                                                                });
                                                            } else {
                                                                // Get regular text content
                                                                text = doc.body.textContent || doc.body.innerText;
                                                            }

                                                            return text.trim();
                                                        }

                                                        return inner;
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
                                            text: `<span class="d-flex align-items-center"><i class="icon-base bx bx-file me-1"></i>Csv</span>`,
                                            className: 'dropdown-item',
                                            exportOptions: {
                                                columns: [3, 4, 5],
                                                format: {
                                                    body: function (inner, coldex, rowdex) {
                                                        if (inner.length <= 0) return inner;

                                                        // Parse HTML content
                                                        const parser = new DOMParser();
                                                        const doc = parser.parseFromString(inner, 'text/html');

                                                        let text = '';

                                                        // Handle user-name elements specifically
                                                        const userNameElements = doc.querySelectorAll('.user-name');
                                                        if (userNameElements.length > 0) {
                                                            userNameElements.forEach(el => {
                                                                // Get text from nested structure - try different selectors
                                                                const nameText =
                                                                    el.querySelector('.fw-medium')?.textContent ||
                                                                    el.querySelector('.d-block')?.textContent ||
                                                                    el.textContent;
                                                                text += nameText.trim() + ' ';
                                                            });
                                                        } else {
                                                            // Handle other elements (status, role, etc)
                                                            text = doc.body.textContent || doc.body.innerText;
                                                        }

                                                        return text.trim();
                                                    }
                                                }
                                            }
                                        },
                                        {
                                            extend: 'excel',
                                            text: `<span class="d-flex align-items-center"><i class="icon-base bx bxs-file-export me-1"></i>Excel</span>`,
                                            className: 'dropdown-item',
                                            exportOptions: {
                                                columns: [3, 4, 5],
                                                format: {
                                                    body: function (inner, coldex, rowdex) {
                                                        if (inner.length <= 0) return inner;

                                                        // Parse HTML content
                                                        const parser = new DOMParser();
                                                        const doc = parser.parseFromString(inner, 'text/html');

                                                        let text = '';

                                                        // Handle user-name elements specifically
                                                        const userNameElements = doc.querySelectorAll('.user-name');
                                                        if (userNameElements.length > 0) {
                                                            userNameElements.forEach(el => {
                                                                // Get text from nested structure - try different selectors
                                                                const nameText =
                                                                    el.querySelector('.fw-medium')?.textContent ||
                                                                    el.querySelector('.d-block')?.textContent ||
                                                                    el.textContent;
                                                                text += nameText.trim() + ' ';
                                                            });
                                                        } else {
                                                            // Handle other elements (status, role, etc)
                                                            text = doc.body.textContent || doc.body.innerText;
                                                        }

                                                        return text.trim();
                                                    }
                                                }
                                            }
                                        },
                                        {
                                            extend: 'pdf',
                                            text: `<span class="d-flex align-items-center"><i class="icon-base bx bxs-file-pdf me-1"></i>Pdf</span>`,
                                            className: 'dropdown-item',
                                            exportOptions: {
                                                columns: [3, 4, 5],
                                                format: {
                                                    body: function (inner, coldex, rowdex) {
                                                        if (inner.length <= 0) return inner;

                                                        // Parse HTML content
                                                        const parser = new DOMParser();
                                                        const doc = parser.parseFromString(inner, 'text/html');

                                                        let text = '';

                                                        // Handle user-name elements specifically
                                                        const userNameElements = doc.querySelectorAll('.user-name');
                                                        if (userNameElements.length > 0) {
                                                            userNameElements.forEach(el => {
                                                                // Get text from nested structure - try different selectors
                                                                const nameText =
                                                                    el.querySelector('.fw-medium')?.textContent ||
                                                                    el.querySelector('.d-block')?.textContent ||
                                                                    el.textContent;
                                                                text += nameText.trim() + ' ';
                                                            });
                                                        } else {
                                                            // Handle other elements (status, role, etc)
                                                            text = doc.body.textContent || doc.body.innerText;
                                                        }

                                                        return text.trim();
                                                    }
                                                }
                                            }
                                        },
                                        {
                                            extend: 'copy',
                                            text: `<i class="icon-base bx bx-copy me-1"></i>Copy`,
                                            className: 'dropdown-item',
                                            exportOptions: {
                                                columns: [3, 4, 5],
                                                format: {
                                                    body: function (inner, coldex, rowdex) {
                                                        if (inner.length <= 0) return inner;

                                                        // Parse HTML content
                                                        const parser = new DOMParser();
                                                        const doc = parser.parseFromString(inner, 'text/html');

                                                        let text = '';

                                                        // Handle user-name elements specifically
                                                        const userNameElements = doc.querySelectorAll('.user-name');
                                                        if (userNameElements.length > 0) {
                                                            userNameElements.forEach(el => {
                                                                // Get text from nested structure - try different selectors
                                                                const nameText =
                                                                    el.querySelector('.fw-medium')?.textContent ||
                                                                    el.querySelector('.d-block')?.textContent ||
                                                                    el.textContent;
                                                                text += nameText.trim() + ' ';
                                                            });
                                                        } else {
                                                            // Handle other elements (status, role, etc)
                                                            text = doc.body.textContent || doc.body.innerText;
                                                        }

                                                        return text.trim();
                                                    }
                                                }
                                            }
                                        }
                                    ]
                                },
                                ...(window.userPermissions.create ? [{
                                    text: '<span class="d-flex align-items-center gap-2">' + '<i class="icon-base bx bx-plus icon-sm"></i>' + '<span class="d-none d-sm-inline-block">Add New Customer</span>' + '</span>', 
                                    className: 'create-new btn btn-primary',
                                    action: function () {
                                        window.location.href = `${baseUrl}company-list/create`;
                                    }
                                }] : [])

                            ]
                        }
                    ]
                },
                topStart: {
                    rowClass: 'row m-3 my-0 justify-content-between',
                    features: [
                        {
                            pageLength: {
                                menu: [10, 25, 50, 100],
                                text: 'Show_MENU_entries'
                            }
                        }
                    ]
                },
                topEnd: {
                    search: {
                        placeholder: ''
                    }
                },
                bottomStart: {
                    rowClass: 'row mx-3 justify-content-between',
                    features: ['info']
                },
                bottomEnd: 'paging'
            },
            language: {
                paginate: {
                    next: '<i class="icon-base bx bx-chevron-right scaleX-n1-rtl icon-1.125rem"></i>',
                    previous: '<i class="icon-base bx bx-chevron-left scaleX-n1-rtl icon-1.125rem"></i>',
                    first: '<i class="icon-base bx bx-chevrons-left scaleX-n1-rtl icon-1.125rem"></i>',
                    last: '<i class="icon-base bx bx-chevrons-right scaleX-n1-rtl icon-1.125rem"></i>'
                }
            },
            responsive: {
                details: {
                    display: DataTable.Responsive.display.modal({
                        header: function (row) {
                            const data = row.data();
                            return 'Details of ' + data['full_name'];
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
                            table.classList.add('datatables-basic');
                            const tbody = document.createElement('tbody');
                            tbody.innerHTML = data;
                            table.appendChild(tbody);
                            return div;
                        }
                        return false;
                    }
                }
            }
        });

        // Delete Record
        document.addEventListener('click', function (e) {
            if (e.target.closest('.delete-record')) {
                const deleteBtn = e.target.closest('.delete-record');
                const company_id = deleteBtn.dataset.id;
                const dtrModal = document.querySelector('.dtr-bs-modal.show');

                // hide responsive modal in small screen
                if (dtrModal) {
                    const bsModal = bootstrap.Modal.getOrCreateInstance(dtrModal);
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
                        fetch(`${baseUrl}company-list/${company_id}`, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': document
                                    .querySelector('meta[name="csrf-token"]')
                                    .getAttribute('content'),
                                'Content-Type': 'application/json'
                            }
                        })
                            .then(response => {
                                if (response.ok) {
                                    dt_basic.ajax.reload(null, false);

                                    // success sweetalert
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Deleted!',
                                        text: 'The company has been deleted!',
                                        customClass: {
                                            confirmButton: 'btn btn-success'
                                        }
                                    });
                                } else {
                                    throw new Error('Delete failed');
                                }
                            })
                            .catch(error => {
                                console.log(error);
                            });
                    } else if (result.dismiss === Swal.DismissReason.cancel) {
                        Swal.fire({
                            title: 'Cancelled',
                            text: 'The company is not deleted!',
                            icon: 'error',
                            customClass: {
                                confirmButton: 'btn btn-success'
                            }
                        });
                    }
                });
            }
        });

    }

    // Filter form control to default size
    // ? setTimeout used for multilingual table initialization
    setTimeout(() => {
        const elementsToModify = [
            { selector: '.dt-buttons .btn', classToRemove: 'btn-secondary' },
            { selector: '.dt-search .form-control', classToRemove: 'form-control-sm', classToAdd: 'ms-4' },
            { selector: '.dt-length .form-select', classToRemove: 'form-select-sm' },
            { selector: '.dt-layout-table', classToRemove: 'row mt-2' },
            { selector: '.dt-layout-end', classToAdd: 'mt-0' },
            { selector: '.dt-layout-end .dt-search', classToAdd: 'mt-0 mt-md-6' },
            { selector: '.dt-layout-start', classToAdd: 'mt-0' },
            { selector: '.dt-layout-end .dt-buttons', classToAdd: 'mb-0' },
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
        // if (data && Object.keys(data).length > 0) {
            Object.entries(data.permissions).forEach(([module, permissions]) => {
                if (module === 'companies') {
                    return;
                }
                if (module === 'users') {
                    module = 'staff';
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
        } else {
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
                bootstrap.Modal.getInstance(document.getElementById('addRoleModal')).hide();
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
