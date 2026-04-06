'use strict';

document.addEventListener('DOMContentLoaded', function () {
  const addRoleForm = document.getElementById('addRoleForm');
  const roleNameInput = document.getElementById('modalRoleName');
  const permissionCheckboxes = document.querySelectorAll('input[name="permissions[]"]');
  const permissionContainer = document.querySelector('.table-responsive');

  // --- Live validation for role name ---
  roleNameInput.addEventListener('input', function () {
    removeRoleNameError();
    if (!roleNameInput.value.trim()) {
      showRoleNameError('Please enter a role name');
    }
  });

  // --- Live validation for permissions ---
  /* permissionCheckboxes.forEach(cb => {
        cb.addEventListener('change', function () {
            removePermissionError();
            if (document.querySelectorAll('input[name="permissions[]"]:checked').length === 0) {
                showPermissionError('Please select at least one permission');
            }
        });
    }); */

  // --- Open edit modal and populate data ---
  document.querySelectorAll('.role-edit-modal').forEach(btn => {
    btn.addEventListener('click', function () {
      const roleId = btn.dataset.roleId; // assuming button has data-id="roleId"

      const roleName = btn.dataset.name; // data-name="Role Name"
      const rolePermissions = JSON.parse(btn.dataset.permissions || '[]'); // array of permission values

      // Set role name
      roleNameInput.value = roleName;

      // Reset all checkboxes
      permissionCheckboxes.forEach(cb => (cb.checked = false));

      // Check role's permissions
      permissionCheckboxes.forEach(cb => {
        if (rolePermissions.includes(cb.value)) {
          cb.checked = true;
        }
      });

      // Update modal title
      document.querySelector('.role-title').textContent = 'Edit Role';

      // Store roleId for submission
      addRoleForm.dataset.roleId = roleId;
    });
  });

  // --- Form submit ---
  addRoleForm.addEventListener('submit', function (e) {
    e.preventDefault();
    let isValid = true;

    // Validate role name
    removeRoleNameError();
    if (!roleNameInput.value.trim()) {
      showRoleNameError('Please enter a role name');
      isValid = false;
    }

    // Validate permissions
    /* removePermissionError();
        if (document.querySelectorAll('input[name="permissions[]"]:checked').length === 0) {
            showPermissionError('Please select at least one permission');
            isValid = false;
        } */

    if (!isValid) return;

    // Proceed with AJAX
    const roleName = roleNameInput.value.trim();
    const permissions = Array.from(document.querySelectorAll('input[name="permissions[]"]:checked')).map(
      input => input.value
    );

    const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    const roleId = addRoleForm.dataset.roleId;
    const url = roleId ? `/roles/${roleId}` : '/roles';
    const method = roleId ? 'PUT' : 'POST';

    fetch(url, {
      method: method,
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': token
      },
      body: JSON.stringify({
        name: roleName,
        permissions: permissions
      })
    })
      .then(res => res.json())
      .then(data => {
        if (data.success) {
          bootstrap.Modal.getInstance(document.getElementById('addRoleModal'))?.hide();

          Swal.fire({
            icon: 'success',
            title: 'Success',
            text: roleId ? `Role "${roleName}" updated successfully.` : `Role "${roleName}" created successfully.`,
            customClass: { confirmButton: 'btn btn-success' }
          });

          addRoleForm.reset();
          removeRoleNameError();
          removePermissionError();
        } else {
          Swal.fire({
            icon: 'error',
            title: 'Error',
            text: data.message || 'Something went wrong!',
            customClass: { confirmButton: 'btn btn-danger' }
          });
        }
      })
      .catch(err => {
        console.error(err);
        Swal.fire({
          icon: 'error',
          title: 'Error',
          text: 'Server error! Try again later.',
          customClass: { confirmButton: 'btn btn-danger' }
        });
      });
  });

  // --- Helper functions ---
  function showRoleNameError(msg) {
    roleNameInput.classList.add('is-invalid');
    const errorEl = document.createElement('div');
    errorEl.className = 'invalid-feedback';
    errorEl.innerText = msg;
    roleNameInput.parentNode.appendChild(errorEl);
  }

  function removeRoleNameError() {
    roleNameInput.classList.remove('is-invalid');
    const errorEl = roleNameInput.parentNode.querySelector('.invalid-feedback');
    if (errorEl) errorEl.remove();
  }

  function showPermissionError(msg) {
    const errorEl = document.createElement('div');
    errorEl.className = 'invalid-feedback d-block';
    errorEl.innerText = msg;
    permissionContainer.appendChild(errorEl);
  }

  function removePermissionError() {
    const errorEl = permissionContainer.querySelector('.invalid-feedback');
    if (errorEl) errorEl.remove();
  }
});

// Update modal title on add/edit
const roleEditList = document.querySelectorAll('.role-edit-modal');
const roleAdd = document.querySelector('.add-new-role');
const roleTitle = document.querySelector('.role-title');

roleAdd?.addEventListener('click', () => (roleTitle.innerText = 'Add New Role'));
roleEditList.forEach(el => {
  el.addEventListener('click', () => (roleTitle.innerText = 'Edit Role'));
});
