@extends('layouts/layoutMaster')

@section('title', 'User List - Pages')

@section('vendor-style')
@vite(['resources/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.scss',
'resources/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.scss',
'resources/assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.scss',
'resources/assets/vendor/libs/select2/select2.scss',
'resources/assets/vendor/libs/@form-validation/form-validation.scss',
'resources/assets/vendor/libs/animate-css/animate.scss', 'resources/assets/vendor/libs/sweetalert2/sweetalert2.scss'])
@endsection

@section('vendor-script')
@vite(['resources/assets/vendor/libs/moment/moment.js',
'resources/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js',
'resources/assets/vendor/libs/select2/select2.js', 'resources/assets/vendor/libs/@form-validation/popular.js',
'resources/assets/vendor/libs/@form-validation/bootstrap5.js',
'resources/assets/vendor/libs/@form-validation/auto-focus.js', 'resources/assets/vendor/libs/cleave-zen/cleave-zen.js',
'resources/assets/vendor/libs/sweetalert2/sweetalert2.js'])
@endsection

@section('page-script')

<script>
    window.AUTH_ROLE = @json(auth()->user()->can('super.users.create'));
</script>
@vite('resources/js/app-user-list.js')
@endsection

@section('content')
<div class="row g-6 mb-6">
	<div class="col-sm-6 col-xl-3">
		<div class="card">
			<div class="card-body">
				<div class="d-flex align-items-start justify-content-between">
					<div class="content-left">
						<span class="text-heading">Session</span>
						<div class="d-flex align-items-center my-1">
							<h4 class="mb-0 me-2">21,459</h4>
							<p class="text-success mb-0">(+29%)</p>
						</div>
						<small class="mb-0">Total Users</small>
					</div>
					<div class="avatar">
						<span class="avatar-initial rounded bg-label-primary">
							<i class="icon-base bx bx-group icon-lg"></i>
						</span>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="col-sm-6 col-xl-3">
		<div class="card">
			<div class="card-body">
				<div class="d-flex align-items-start justify-content-between">
					<div class="content-left">
						<span class="text-heading">Paid Users</span>
						<div class="d-flex align-items-center my-1">
							<h4 class="mb-0 me-2">4,567</h4>
							<p class="text-success mb-0">(+18%)</p>
						</div>
						<small class="mb-0">Last week analytics </small>
					</div>
					<div class="avatar">
						<span class="avatar-initial rounded bg-label-danger">
							<i class="icon-base bx bx-user-plus icon-lg"></i>
						</span>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="col-sm-6 col-xl-3">
		<div class="card">
			<div class="card-body">
				<div class="d-flex align-items-start justify-content-between">
					<div class="content-left">
						<span class="text-heading">Active Users</span>
						<div class="d-flex align-items-center my-1">
							<h4 class="mb-0 me-2">19,860</h4>
							<p class="text-danger mb-0">(-14%)</p>
						</div>
						<small class="mb-0">Last week analytics</small>
					</div>
					<div class="avatar">
						<span class="avatar-initial rounded bg-label-success">
							<i class="icon-base bx bx-user-check icon-lg"></i>
						</span>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="col-sm-6 col-xl-3">
		<div class="card">
			<div class="card-body">
				<div class="d-flex align-items-start justify-content-between">
					<div class="content-left">
						<span class="text-heading">Pending Users</span>
						<div class="d-flex align-items-center my-1">
							<h4 class="mb-0 me-2">237</h4>
							<p class="text-success mb-0">(+42%)</p>
						</div>
						<small class="mb-0">Last week analytics</small>
					</div>
					<div class="avatar">
						<span class="avatar-initial rounded bg-label-warning">
							<i class="icon-base bx bx-user-voice icon-lg"></i>
						</span>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- Users List Table -->
<div class="card">
	{{-- <div class="card-header border-bottom">
		<h5 class="card-title mb-0">Search Filters</h5>
		<div class="d-flex justify-content-between align-items-center row pt-4 gap-md-0 g-6">
			<div class="col-md-4 user_role"></div>
			<div class="col-md-4 user_status"></div>
		</div>
	</div> --}}
	<div class="card-datatable">
		<table class="datatables-users table border-top">
			<thead>
				<tr>
					<th></th>
					<th></th>
					<th>Staff</th>
					<th>Role</th>
					<th>Status</th>
					<th>Actions</th>
				</tr>
			</thead>
		</table>
	</div>
	<!-- Offcanvas to add new user -->
	<div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasAddUser" aria-labelledby="offcanvasAddUserLabel">
		<div class="offcanvas-header border-bottom">
			<h5 id="offcanvasAddUserLabel" class="offcanvas-title">Add User</h5>
			<button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
		</div>
		<div class="offcanvas-body mx-0 flex-grow-0 p-6 h-100">
			<form class="add-new-user pt-0" id="addNewUserForm">
				@csrf
				<input type="hidden" name="id" id="user_id">

				<div class="mb-6">
					<label class="form-label" for="add-user-fname">First Name</label>
					<input type="text" class="form-control" id="add-user-fname" name="fname" required />
				</div>

				<div class="mb-6">
					<label class="form-label" for="add-user-lname">Last Name</label>
					<input type="text" class="form-control" id="add-user-lname" name="lname" required />
				</div>

				<div class="mb-6">
					<label class="form-label" for="add-user-email">Email</label>
					<input type="email" id="add-user-email" class="form-control" name="email" required />
				</div>

				<div class="mb-6" id="passwordWrap">
					<label class="form-label" for="add-user-password">Password</label>
					<input type="password" id="add-user-password" class="form-control" name="password" />
					<small class="text-muted">Leave blank to keep existing password (on edit).</small>
				</div>

				<div class="mb-6" id="confirmPasswordWrap">
					<label class="form-label" for="add-user-password">Confirm Password</label>
					<input type="password" id="add-user-password_confirmation" class="form-control"
						name="password_confirmation" />
					<small class="text-muted">Leave blank to keep existing password (on edit).</small>
				</div>

				{{-- Company selection --}}
				{{-- <div class="mb-6" id="companyWrap">
					<label class="form-label" for="add-user-company-id">Company</label>
					<select id="add-user-company-id" class="form-select" name="company_id">
						<option value="">Select Company</option>
						@foreach($companies as $company)
						<option value="{{ $company->id }}">{{ $company->name }}</option>
						@endforeach
					</select>
				</div> --}}

				{{-- Roles (your roles) --}}
				<div class="mb-6" style="display: none;">
					<label class="form-label" for="user-role">User Role</label>
					<select id="user-role" class="form-select" name="role" required>
						@if(auth()->user()->hasRole('super_admin'))
						<option value="admin">Admin (Super Admin Staff)</option>
						{{-- <option value="company">Company</option>
						<option value="staff">Staff (Company Staff)</option> --}}
						@elseif(auth()->user()->hasRole('admin'))
						<option value="company">Company</option>
						{{-- <option value="staff">Staff (Company Staff)</option> --}}
						@elseif(auth()->user()->hasRole('company'))
						<option value="staff">Staff (Company Staff)</option>
						@endif
					</select>
				</div>

				<div class="mb-6">
					<label class="form-label" for="user-status">Status</label>
					<select id="user-status" class="form-select" name="status" required>
						<option value="active">Active</option>
						<option value="suspended">Suspended</option>
					</select>
				</div>

				<button type="submit" class="btn btn-primary me-3 data-submit">Submit</button>
				<button type="reset" class="btn btn-label-danger" data-bs-dismiss="offcanvas">Cancel</button>
			</form>
		</div>
	</div>
</div>


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
