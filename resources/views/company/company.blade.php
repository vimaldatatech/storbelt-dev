@extends('layouts/layoutMaster')

@section('title', 'Company List')

<!-- Vendor Styles -->
@section('vendor-style')
@vite(['resources/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.scss',
'resources/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.scss',
'resources/assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.scss',
'resources/assets/vendor/libs/flatpickr/flatpickr.scss',
'resources/assets/vendor/libs/datatables-rowgroup-bs5/rowgroup.bootstrap5.scss',
'resources/assets/vendor/libs/@form-validation/form-validation.scss',
'resources/assets/vendor/libs/animate-css/animate.scss', 'resources/assets/vendor/libs/sweetalert2/sweetalert2.scss'])
@endsection

<!-- Vendor Scripts -->
@section('vendor-script')
@vite(['resources/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js',
'resources/assets/vendor/libs/moment/moment.js', 'resources/assets/vendor/libs/flatpickr/flatpickr.js',
'resources/assets/vendor/libs/@form-validation/popular.js',
'resources/assets/vendor/libs/@form-validation/bootstrap5.js',
'resources/assets/vendor/libs/@form-validation/auto-focus.js', 'resources/assets/vendor/libs/cleave-zen/cleave-zen.js',
'resources/assets/vendor/libs/sweetalert2/sweetalert2.js'])
@endsection

<!-- Page Scripts -->
@section('page-script')
<script>
    // window.authUserRoles = @json(auth()->user()->getRoleNames());
    window.userPermissions = {
        view: @json(auth()->user()->can('super.companies.view')),
        create: @json(auth()->user()->can('super.companies.create')),
        edit: @json(auth()->user()->can('super.companies.edit')),
        delete: @json(auth()->user()->can('super.companies.delete')),
    };
</script>
@if(session('status'))
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: "{{ session('status') }}",
                confirmButtonColor: '#696cff'
            });
        });
    </script>
@endif
@if($errors->any())
    <script>
        document.addEventListener('DOMContentLoaded', function () {

            Swal.fire({
                icon: 'error',
                title: 'Validation Error',
                html: `{!! implode('<br>', $errors->all()) !!}`,
                confirmButtonColor: '#ff3e1d'
            });

            var offcanvas = new bootstrap.Offcanvas(document.getElementById('offcanvasAddCompany'));
            offcanvas.show();
        });
    </script>
@endif
@vite(['resources/js/company-list.js'])
@endsection

@section('content')
<!-- DataTable with Buttons -->
<div class="card">
    <div class="card-datatable text-nowrap">
        <table class="datatables-basic table table-bordered table-responsive">
            <thead>
                <tr>
                    <th></th>
                    <th></th>
                    <th>Id</th>
                    <th>Company Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Status</th>
                    <th class="d-flex align-items-center">Action</th>
                </tr>
            </thead>
        </table>
    </div>
</div>
<!--/ DataTable with Buttons -->

<div class="modal fade" id="addRoleModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-simple modal-dialog-centered modal-add-new-role">
        <div class="modal-content">
            <div class="modal-body">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                <!-- Add role form -->
                <form id="assignUserPermission" class="row g-6">
                    <input type="hidden" id="permission_user_id" name="user_id">
                    <div class="col-12">
                        <h5 class="mb-6">Roles & Permissions</h5>
                        <!-- Permission table -->
                        <div class="table-responsive">
                            <table class="table table-flush-spacing mb-0 border-top">
                                <tbody id="permissionTableBody"></tbody>
                            </table>
                        </div>
                        <!-- Permission table -->
                    </div>
                    <div class="col-12 text-center">
                        <button type="submit" class="btn btn-primary me-sm-3 me-1">Submit</button>
                        <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="modal"
                        aria-label="Close">Cancel</button>
                    </div>
                </form>
                <!--/ Add role form -->
            </div>
        </div>
    </div>
</div>

@endsection
