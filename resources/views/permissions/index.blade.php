@extends('layouts/layoutMaster')

@section('title', 'Permissions')

@section('vendor-style')
@vite(['resources/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.scss',
'resources/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.scss',
'resources/assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.scss',
'resources/assets/vendor/libs/@form-validation/form-validation.scss',
'resources/assets/vendor/libs/animate-css/animate.scss',
'resources/assets/vendor/libs/sweetalert2/sweetalert2.scss'])
@endsection

@section('vendor-script')
@vite(['resources/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js',
'resources/assets/vendor/libs/@form-validation/popular.js',
'resources/assets/vendor/libs/@form-validation/bootstrap5.js',
'resources/assets/vendor/libs/@form-validation/auto-focus.js',
'resources/assets/vendor/libs/cleave-zen/cleave-zen.js',
'resources/assets/vendor/libs/sweetalert2/sweetalert2.js'])
@endsection

@section('page-script')
@vite(['resources/js/permissions/app-access-permission.js'])
@endsection

@section('content')
<!-- Permission Table -->
<div class="card">
    <div class="card-datatable table-responsive">
        <table class="datatables-permissions table">
            <thead class="border-top">
                <tr>
                    <th></th>
                    <th></th>
                    <th>Name</th>
                    <th>Created Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
        </table>
    </div>
</div>
<!--/ Permission Table -->

<!-- Modal -->
<div class="modal fade" id="permissionModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-simple">
        <div class="modal-content">
            <div class="modal-body">
                <button type="button" class="btn-close btn-pinned" data-bs-dismiss="modal"></button>

                <div class="text-center mb-6">
                    <h4 id="permissionModalTitle">Add Permission</h4>
                    <p id="permissionModalDesc">Create a new permission.</p>
                </div>

                <form id="permissionForm" class="row" onsubmit="return false">
                    <input type="hidden" id="permissionId">
                    <input type="hidden" id="permissionMode" value="create">

                    <div class="col-12 form-control-validation mb-4">
                        <label class="form-label">Module</label>
                        <select id="permissionModule" name="permissionModule" class="form-select">
                            <!-- options injected by JS -->
                        </select>
                        </div>

                        <div class="col-12 form-control-validation mb-4">
                        <label class="form-label">Action</label>
                        <select id="permissionAction" name="permissionAction" class="form-select">
                            <!-- options injected by JS -->
                        </select>
                    </div>
                    <div class="col-12 form-control-validation mb-4">
                        <label class="form-label">Permission Name</label>
                        <input type="text" id="permissionName" name="permissionName" class="form-control" placeholder="Permission Name" readonly />
                    </div>

                    <div class="col-12 text-center">
                        <button type="submit" class="btn btn-primary" id="permissionSubmitBtn">
                            Create Permission
                        </button>
                        <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="modal">
                            Discard
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>

<!-- /Modal -->
@endsection
