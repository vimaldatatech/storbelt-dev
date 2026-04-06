/**
 * App user list (js)
 */

'use strict';

document.addEventListener('DOMContentLoaded', function (e) {
  const moduleSelect = document.getElementById('permissionModule');
  const actionSelect = document.getElementById('permissionAction');
  const dataTablePermissions = document.querySelector('.datatables-permissions'),
    userList = baseUrl + 'app/user/list';
  let dt_permission;

  // Users List datatable
  if (dataTablePermissions) {
    dt_permission = new DataTable(dataTablePermissions, {
      ajax: baseUrl + 'permission/list/', // JSON file to add data
      columns: [
        // columns according to JSON
        { data: 'id' },
        { data: 'id' },
        { data: 'name' },
        { data: 'created_date' },
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
          targets: 1,
          searchable: false,
          visible: false
        },
        {
          // Name
          targets: 2,
          render: function (data, type, full, meta) {
            let name = full['name'];
            return '<span class="text-nowrap text-heading">' + name + '</span>';
          }
        },
        {
          targets: 3,
          orderable: false,
          render: function (data, type, full, meta) {
            let date = new Date(full['created_at']);
            let day = String(date.getDate()).padStart(2, '0');
            let month = String(date.getMonth() + 1).padStart(2, '0'); // months are 0-indexed
            let year = date.getFullYear();
            return '<span class="text-nowrap">' + day + '-' + month + '-' + year + '</span>';
          }
        },
        {
          // Actions
          targets: -1,
          searchable: false,
          title: 'Actions',
          orderable: false,
          render: function (data, type, full, meta) {
            return `
              <div class="d-flex align-items-center">
                <span class="text-nowrap">
                  <button class="btn btn-icon me-1 edit-permission" data-id="${full.id}" data-name="${full.name}" data-bs-toggle="modal" data-bs-target="#permissionModal"><i class="icon-base bx bx-edit icon-md"></i></button>
                </span>
              </div>
            `;
          }
        }
      ],
      order: [[1, 'asc']],
      layout: {
        topStart: {
          rowClass: 'row m-3 my-0 justify-content-between',
          features: [
            {
              pageLength: {
                menu: [10, 25, 50, 100],
                text: 'Show_MENU_'
              }
            }
          ]
        },
        topEnd: {
          features: [
            {
              search: {
                placeholder: 'Search Permission',
                text: '_INPUT_'
              }
            },
            {
              buttons: [
                {
                  text: `<i class="icon-base bx bx-plus icon-xs me-0 me-sm-2"></i><span class="d-none d-sm-inline-block">Add Permission</span>`,
                  className: 'add-new btn btn-primary',
                  attr: {
                    'data-bs-toggle': 'modal',
                    'data-bs-target': '#permissionModal'
                  }
                }
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
        paginate: {
          next: '<i class="icon-base bx bx-chevron-right scaleX-n1-rtl icon-18px"></i>',
          previous: '<i class="icon-base bx bx-chevron-left scaleX-n1-rtl icon-18px"></i>',
          first: '<i class="icon-base bx bx-chevrons-left scaleX-n1-rtl icon-18px"></i>',
          last: '<i class="icon-base bx bx-chevrons-right scaleX-n1-rtl icon-18px"></i>'
        }
      },
      responsive: {
        details: {
          display: DataTable.Responsive.display.modal({
            header: function (row) {
              const data = row.data();
              return 'Details of ' + data['name'];
            }
          }),
          type: 'column',
          renderer: function (api, rowIdx, columns) {
            const data = columns
              .map(function (col) {
                return col.title !== '' //? Do not show row in modal popup if title is blank (for check box)
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
      }
    });
  }

  // Filter form control to default size
  // ? setTimeout used for multilingual table initialization
  setTimeout(() => {
    const elementsToModify = [
      { selector: '.dt-buttons .btn', classToRemove: 'btn-secondary' },
      { selector: '.dt-search', classToAdd: 'me-4' },
      { selector: '.dt-search .form-control', classToRemove: 'form-control-sm' },
      { selector: '.dt-length', classToAdd: 'mb-0 mb-md-5' },
      { selector: '.dt-length .form-select', classToRemove: 'form-select-sm' },
      { selector: '.dt-buttons', classToAdd: 'mb-0 w-auto' },
      { selector: '.dt-layout-start', classToAdd: 'mt-0 px-5' },
      {
        selector: '.dt-layout-end',
        classToAdd: 'justify-content-md-between justify-content-center d-flex',
        classToRemove: 'justify-content-between d-md-flex'
      },
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

  const modal = document.getElementById('permissionModal');
  const form = document.getElementById('permissionForm');

  const idInput = document.getElementById('permissionId');
  const modeInput = document.getElementById('permissionMode');
  const nameInput = document.getElementById('permissionName');

  const title = document.getElementById('permissionModalTitle');
  const desc = document.getElementById('permissionModalDesc');
  const submitBtn = document.getElementById('permissionSubmitBtn');

  // 🔹 Init validation
  const fv = FormValidation.formValidation(form, {
    fields: {
      permissionName: {
        validators: {
          notEmpty: {
            message: 'Please enter permission name'
          }
        }
      }
    },
    plugins: {
      trigger: new FormValidation.plugins.Trigger(),
      bootstrap5: new FormValidation.plugins.Bootstrap5({
        eleValidClass: '',
        rowSelector: '.form-control-validation'
      }),
      submitButton: new FormValidation.plugins.SubmitButton(),
      autoFocus: new FormValidation.plugins.AutoFocus()
    }
  });

  fetch(`${baseUrl}permission/meta`, { headers: { Accept: 'application/json' } })
    .then(res => res.json())
    .then(meta => {
      // modules
      moduleSelect.innerHTML = meta.modules.map(m => `<option value="${m}">${m}</option>`).join('');
      // actions
      actionSelect.innerHTML = meta.actions.map(a => `<option value="${a}">${a}</option>`).join('');

      // set default + generate name
      generatePermissionKey();
    });

  // 🔹 Open modal in CREATE mode
  document.addEventListener('click', function (e) {
    if (e.target.closest('.add-new')) {
      form.reset();
      fv.resetForm(true);

      modeInput.value = 'create';
      idInput.value = '';

        // 👉 select first module & action
        if (moduleSelect.options.length > 0) {
        moduleSelect.selectedIndex = 0;
        }
        if (actionSelect.options.length > 0) {
        actionSelect.selectedIndex = 0;
        }

        // 👉 generate name immediately
        generatePermissionKey();

      title.innerText = 'Add Permission';
      desc.innerText = 'Create a new permission.';
      submitBtn.innerText = 'Create Permission';
    }
  });

  // 🔹 Open modal in EDIT mode
  document.addEventListener('click', function (e) {
    const btn = e.target.closest('.edit-permission');
    if (!btn) return;

    form.reset();
    fv.resetForm(true);

    modeInput.value = 'edit';
    idInput.value = btn.dataset.id;
    nameInput.value = btn.dataset.name;

    const parts = (btn.dataset.name || '').split('.');
    if (parts.length === 2) {
      moduleSelect.value = parts[0];
      actionSelect.value = parts[1];
      generatePermissionKey();
    }

    title.innerText = 'Edit Permission';
    desc.innerText = 'Update permission details.';
    submitBtn.innerText = 'Update Permission';
  });

  // 🔹 Submit handler (Create / Update)
  fv.on('core.form.valid', function () {
    const id = document.getElementById('permissionId').value;
    const nameInput = document.getElementById('permissionName');
    const form = document.getElementById('permissionForm');

    const url = id ? `${baseUrl}permissions/${id}` : `${baseUrl}permissions`;
    const method = id ? 'PUT' : 'POST';

    fetch(url, {
      method: method,
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
      },
      body: JSON.stringify({
        module: moduleSelect.value,
        action: actionSelect.value
      })
    })
    .then(res => {
        if (!res.ok) return res.json().then(err => Promise.reject(err));
        return res.json();
    })
    .then(data => {
        // Get Bootstrap modal instance
        const modalEl = document.getElementById('permissionModal');
        const modalInstance = bootstrap.Modal.getInstance(modalEl);

        // Listen once for modal fully hidden
        modalEl.addEventListener('hidden.bs.modal', function handler() {
          // Show SweetAlert after modal is fully hidden
          Swal.fire({
            icon: 'success',
            title: 'Success',
            text: id ? 'Permission updated successfully.' : 'Permission created successfully.',
            customClass: { confirmButton: 'btn btn-success' }
          });
          modalEl.removeEventListener('hidden.bs.modal', handler); // remove listener
        });

        // Hide the modal
        modalInstance.hide();

        // Reset form and reload table
        form.reset();
        dt_permission.ajax.reload(null, false);
      })
      .catch(err => {
        alert(err.message || 'Something went wrong');
        console.error(err);
      });
  });
  function generatePermissionKey() {
    const m = (moduleSelect.value || '').trim();
    const a = (actionSelect.value || '').trim();
    nameInput.value = m && a ? `${m}.${a}` : '';
  }

  moduleSelect.addEventListener('change', generatePermissionKey);
  actionSelect.addEventListener('change', generatePermissionKey);
});
