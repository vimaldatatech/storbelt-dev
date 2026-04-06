@php
  $configData = Helper::appClasses();
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Roles - Apps')

@section('vendor-style')
  @vite(['resources/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.scss', 'resources/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.scss', 'resources/assets/vendor/libs/@form-validation/form-validation.scss', 'resources/assets/vendor/libs/sweetalert2/sweetalert2.scss'])
@endsection

@section('vendor-script')
  @vite(['resources/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js', 'resources/assets/vendor/libs/@form-validation/popular.js', 'resources/assets/vendor/libs/@form-validation/bootstrap5.js', 'resources/assets/vendor/libs/@form-validation/auto-focus.js', 'resources/assets/vendor/libs/sweetalert2/sweetalert2.js'])
@endsection

@section('page-script')
  @vite(['resources/js/roles/modal-add-role.js'])
@endsection

@section('content')
    <h4 class="mb-1">Roles List</h4>

    <p class="mb-6">A role provided access to predefined menus and features so that depending on assigned role an
    administrator can have access to what user needs.</p>
    <!-- Role cards -->
    <div class="row g-6">
        <div class="col-xl-4 col-lg-6 col-md-6">
            <div class="card h-100">
                <div class="row h-100">
                    <div class="col-sm-5">
                        <div class="d-flex align-items-end h-100 justify-content-center mt-sm-0 mt-4 ps-6">
                            <img src="{{ asset('assets/img/illustrations/lady-with-laptop-' . $configData['theme'] . '.png') }}" class="img-fluid" alt="Image" width="120" data-app-light-img="illustrations/lady-with-laptop-light.png" data-app-dark-img="illustrations/lady-with-laptop-dark.png" />
                        </div>
                    </div>
                    <div class="col-sm-7">
                        <div class="card-body text-sm-end text-center ps-sm-0">
                            <button data-bs-target="#addRoleModal" data-bs-toggle="modal" class="btn btn-sm btn-primary mb-4 text-nowrap add-new-role">Add New Role</button>
                            <p class="mb-0">Add new role, <br />if it doesn't exist.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if ($roles->isNotEmpty())
            @foreach ($roles as $role)
                <div class="col-xl-4 col-lg-6 col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <h6 class="fw-normal mb-0 text-body">Total {{ $role->users_count }} users</h6>
                                <ul class="list-unstyled d-flex align-items-center avatar-group mb-0">
                                    <li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" title="Vinnie Mostowy" class="avatar pull-up">
                                        <img class="rounded-circle" src="{{ asset('assets/img/avatars/5.png') }}" alt="Avatar" />
                                    </li>
                                    <li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" title="Allen Rieske" class="avatar pull-up">
                                        <img class="rounded-circle" src="{{ asset('assets/img/avatars/12.png') }}" alt="Avatar" />
                                    </li>
                                    <li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" title="Julee Rossignol" class="avatar pull-up">
                                        <img class="rounded-circle" src="{{ asset('assets/img/avatars/6.png') }}" alt="Avatar" />
                                    </li>
                                    <li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" title="Kaith D'souza" class="avatar pull-up">
                                        <img class="rounded-circle" src="{{ asset('assets/img/avatars/3.png') }}" alt="Avatar" />
                                    </li>
                                </ul>
                            </div>
                            <div class="d-flex justify-content-between align-items-end">
                                <div class="role-heading">
                                    <h5 class="mb-1">{{ ucwords(str_replace("_"," ",$role->name)) }}</h5>
                                    <a href="javascript:;" data-bs-toggle="modal" data-bs-target="#addRoleModal" data-role-id="{{ $role->id }}" data-name="{{ ucwords(str_replace("_"," ",$role->name)) }}" class="role-edit-modal"><span>Edit Role</span></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>                
            @endforeach
        @endif  
    </div>
    <!--/ Role cards -->

    <!-- Add Role Modal -->
    <div class="modal fade" id="addRoleModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-simple modal-dialog-centered modal-add-new-role">
            <div class="modal-content">
                <div class="modal-body">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    <div class="text-center mb-6">
                    <h4 class="role-title mb-2" id="headingOfRole">Add New Role</h4>
                    <p>Set role permissions</p>
                    </div>
                    <!-- Add role form -->
                    <form id="addRoleForm" class="row g-6">
                        <div class="col-12 form-control-validation">
                            <label class="form-label" for="modalRoleName">Role Name</label>
                            <input type="text" id="modalRoleName" name="modalRoleName" class="form-control" placeholder="Enter a role name"/>
                        </div>
                        <div class="col-12">
                            <h5 class="mb-6">Role Permissions</h5>
                            <!-- Permission table -->
                            <div class="table-responsive">
                            <table class="table table-flush-spacing mb-0 border-top">
                                <tbody>
                                <tr>
                                    <td class="text-nowrap fw-medium text-heading">Administrator Access <i
                                        class="icon-base bx bx-info-circle" data-bs-toggle="tooltip" data-bs-placement="top"
                                        title="Allows a full access to the system"></i></td>
                                    <td>
                                    <div class="d-flex justify-content-end">
                                        <div class="form-check mb-0">
                                        <input class="form-check-input" type="checkbox" id="selectAll" />
                                        <label class="form-check-label" for="selectAll"> Select All </label>
                                        </div>
                                    </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-nowrap fw-medium text-heading">User Management</td>
                                    <td>
                                    <div class="d-flex justify-content-end">
                                        <div class="form-check mb-0 me-4 me-lg-12">
                                            <input class="form-check-input" type="checkbox" id="userManagementRead" name="permissions[]" value="user.read"/>
                                            <label class="form-check-label" for="userManagementRead"> Read </label>
                                        </div>
                                        <div class="form-check mb-0 me-4 me-lg-12">
                                            <input class="form-check-input" type="checkbox" id="userManagementWrite" name="permissions[]" value="user.read" />
                                            <label class="form-check-label" for="userManagementWrite"> Write </label>
                                        </div>
                                        <div class="form-check mb-0">
                                            <input class="form-check-input" type="checkbox" id="userManagementCreate" name="permissions[]" value="user.read" />
                                            <label class="form-check-label" for="userManagementCreate"> Create </label>
                                        </div>
                                    </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-nowrap fw-medium text-heading">Content Management</td>
                                    <td>
                                    <div class="d-flex justify-content-end">
                                        <div class="form-check mb-0 me-4 me-lg-12">
                                            <input class="form-check-input" type="checkbox" id="contentManagementRead" name="permissions[]" value="user.read" />
                                            <label class="form-check-label" for="contentManagementRead"> Read </label>
                                        </div>
                                        <div class="form-check mb-0 me-4 me-lg-12">
                                            <input class="form-check-input" type="checkbox" id="contentManagementWrite" name="permissions[]" value="user.read" />
                                            <label class="form-check-label" for="contentManagementWrite"> Write </label>
                                        </div>
                                        <div class="form-check mb-0">
                                            <input class="form-check-input" type="checkbox" id="contentManagementCreate" name="permissions[]" value="user.read" />
                                            <label class="form-check-label" for="contentManagementCreate"> Create </label>
                                        </div>
                                    </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-nowrap fw-medium text-heading">Disputes Management</td>
                                    <td>
                                    <div class="d-flex justify-content-end">
                                        <div class="form-check mb-0 me-4 me-lg-12">
                                        <input class="form-check-input" type="checkbox" id="dispManagementRead" name="permissions[]" value="user.read" />
                                        <label class="form-check-label" for="dispManagementRead"> Read </label>
                                        </div>
                                        <div class="form-check mb-0 me-4 me-lg-12">
                                        <input class="form-check-input" type="checkbox" id="dispManagementWrite" name="permissions[]" value="user.read" />
                                        <label class="form-check-label" for="dispManagementWrite"> Write </label>
                                        </div>
                                        <div class="form-check mb-0">
                                        <input class="form-check-input" type="checkbox" id="dispManagementCreate" name="permissions[]" value="user.read" />
                                        <label class="form-check-label" for="dispManagementCreate"> Create </label>
                                        </div>
                                    </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-nowrap fw-medium text-heading">Database Management</td>
                                    <td>
                                    <div class="d-flex justify-content-end">
                                        <div class="form-check mb-0 me-4 me-lg-12">
                                        <input class="form-check-input" type="checkbox" id="dbManagementRead" name="permissions[]" value="user.read" />
                                        <label class="form-check-label" for="dbManagementRead"> Read </label>
                                        </div>
                                        <div class="form-check mb-0 me-4 me-lg-12">
                                        <input class="form-check-input" type="checkbox" id="dbManagementWrite" name="permissions[]" value="user.read" />
                                        <label class="form-check-label" for="dbManagementWrite"> Write </label>
                                        </div>
                                        <div class="form-check mb-0">
                                        <input class="form-check-input" type="checkbox" id="dbManagementCreate" name="permissions[]" value="user.read" />
                                        <label class="form-check-label" for="dbManagementCreate"> Create </label>
                                        </div>
                                    </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-nowrap fw-medium text-heading">Financial Management</td>
                                    <td>
                                    <div class="d-flex justify-content-end">
                                        <div class="form-check mb-0 me-4 me-lg-12">
                                        <input class="form-check-input" type="checkbox" id="finManagementRead" name="permissions[]" value="user.read" />
                                        <label class="form-check-label" for="finManagementRead"> Read </label>
                                        </div>
                                        <div class="form-check mb-0 me-4 me-lg-12">
                                        <input class="form-check-input" type="checkbox" id="finManagementWrite" name="permissions[]" value="user.read" />
                                        <label class="form-check-label" for="finManagementWrite"> Write </label>
                                        </div>
                                        <div class="form-check mb-0">
                                        <input class="form-check-input" type="checkbox" id="finManagementCreate" name="permissions[]" value="user.read" />
                                        <label class="form-check-label" for="finManagementCreate"> Create </label>
                                        </div>
                                    </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-nowrap fw-medium text-heading">Reporting</td>
                                    <td>
                                    <div class="d-flex justify-content-end">
                                        <div class="form-check mb-0 me-4 me-lg-12">
                                        <input class="form-check-input" type="checkbox" id="reportingRead" name="permissions[]" value="user.read" />
                                        <label class="form-check-label" for="reportingRead"> Read </label>
                                        </div>
                                        <div class="form-check mb-0 me-4 me-lg-12">
                                        <input class="form-check-input" type="checkbox" id="reportingWrite" name="permissions[]" value="user.read" />
                                        <label class="form-check-label" for="reportingWrite"> Write </label>
                                        </div>
                                        <div class="form-check mb-0">
                                        <input class="form-check-input" type="checkbox" id="reportingCreate" name="permissions[]" value="user.read" />
                                        <label class="form-check-label" for="reportingCreate"> Create </label>
                                        </div>
                                    </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-nowrap fw-medium text-heading">API Control</td>
                                    <td>
                                    <div class="d-flex justify-content-end">
                                        <div class="form-check mb-0 me-4 me-lg-12">
                                        <input class="form-check-input" type="checkbox" id="apiRead" name="permissions[]" value="user.read" />
                                        <label class="form-check-label" for="apiRead"> Read </label>
                                        </div>
                                        <div class="form-check mb-0 me-4 me-lg-12">
                                        <input class="form-check-input" type="checkbox" id="apiWrite" name="permissions[]" value="user.read" />
                                        <label class="form-check-label" for="apiWrite"> Write </label>
                                        </div>
                                        <div class="form-check mb-0">
                                        <input class="form-check-input" type="checkbox" id="apiCreate" name="permissions[]" value="user.read" />
                                        <label class="form-check-label" for="apiCreate"> Create </label>
                                        </div>
                                    </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-nowrap fw-medium text-heading">Repository Management</td>
                                    <td>
                                    <div class="d-flex justify-content-end">
                                        <div class="form-check mb-0 me-4 me-lg-12">
                                        <input class="form-check-input" type="checkbox" id="repoRead" name="permissions[]" value="user.read" />
                                        <label class="form-check-label" for="repoRead"> Read </label>
                                        </div>
                                        <div class="form-check mb-0 me-4 me-lg-12">
                                        <input class="form-check-input" type="checkbox" id="repoWrite" name="permissions[]" value="user.read" />
                                        <label class="form-check-label" for="repoWrite"> Write </label>
                                        </div>
                                        <div class="form-check mb-0">
                                        <input class="form-check-input" type="checkbox" id="repoCreate" name="permissions[]" value="user.read" />
                                        <label class="form-check-label" for="repoCreate"> Create </label>
                                        </div>
                                    </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-nowrap fw-medium text-heading">Payroll</td>
                                    <td>
                                    <div class="d-flex justify-content-end">
                                        <div class="form-check mb-0 me-4 me-lg-12">
                                        <input class="form-check-input" type="checkbox" id="payrollRead" name="permissions[]" value="user.read" />
                                        <label class="form-check-label" for="payrollRead"> Read </label>
                                        </div>
                                        <div class="form-check mb-0 me-4 me-lg-12">
                                        <input class="form-check-input" type="checkbox" id="payrollWrite" name="permissions[]" value="user.read" />
                                        <label class="form-check-label" for="payrollWrite"> Write </label>
                                        </div>
                                        <div class="form-check mb-0">
                                        <input class="form-check-input" type="checkbox" id="payrollCreate" name="permissions[]" value="user.read" />
                                        <label class="form-check-label" for="payrollCreate"> Create </label>
                                        </div>
                                    </div>
                                    </td>
                                </tr>
                                </tbody>
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
    <!-- / Add Role Modal -->
@endsection
