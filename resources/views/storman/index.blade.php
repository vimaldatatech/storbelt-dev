@extends('layouts/layoutMaster')

@section('title', 'StorMan Settings')

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
    @vite('resources/js/storman/storman-settings.js')
@endsection

@section('content')
<div class="card mb-6">
    <h5 class="card-header">Storman Settings</h5>
    <div class="card-body pt-1">
        <form id="formStormanSettings">
            @csrf
            {{-- Storman API URL --}}
            <div class="mb-6 fv-row">
                <label class="form-label" for="api_url">Storman API URL</label>
                <input type="text" class="form-control" id="api_url" name="api_url" value="{{ old('api_url', $company?->storman_api_url ?? '') }}" required>
            </div>

            {{-- Storman API Token --}}
            <div class="mb-6 fv-row">
                <label class="form-label" for="token">Storman API Token</label>
                <input type="text" class="form-control" id="token" name="token" value="{{ old('token', $company?->storman_api_token ?? '') }}" required>
            </div>

            {{-- Facility Code (readonly, no validation) --}}
            {{-- <div class="mb-6 fv-row">
                <label class="form-label" for="facility_code">Facility Code</label>
                <input type="text" class="form-control" id="facility_code" name="facility_code" value="{{ old('facility_code', $company?->code ?? '') }}" readonly>
            </div> --}}

            <div class="mt-4">
                <button type="submit" class="btn btn-primary me-3">Save Data</button>
                <button type="button" id="syncDataBtn" class="btn btn-warning me-3">Sync Data</button>
            </div>
        </form>
    </div>
    <div class="d-flex justify-content-center align-items-center mb-3">
        @if(auth()->user()->last_data_sync)
            <span class="badge bg-label-info">
                Last Synced: {{ auth()->user()->last_data_sync->format('d M Y h:i A') }}
            </span>
        @endif
    </div>

</div>
@if($facilities->isNotEmpty())
    <h5 class="card-header">Facility Details</h5>
    <div class="card-body pt-1">

        <table class="table table-bordered table-striped">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Code</th>
                    <th>Name</th>
                    <th>Short Name</th>
                    <th>Company</th>
                    <th>Phone</th>
                    <th>Email</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($facilities as $index => $f)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $f->code }}</td>
                        <td>{{ $f->name ?? '-' }}</td>
                        <td>{{ $f->short_name ?? '-' }}</td>
                        <td>{{ $f->company_name ?? '-' }}</td>
                        <td>{{ $f->phone ?? '-' }}</td>
                        <td>{{ $f->email ?? '-' }}</td>
                        <td>
                            @if($f->is_active)
                                <span class="badge bg-success">Active</span>
                            @else
                                <span class="badge bg-danger">Inactive</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center">No facilities found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

    </div>
@endif

@endsection
