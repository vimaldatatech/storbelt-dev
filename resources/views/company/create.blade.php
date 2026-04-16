@extends('layouts/layoutMaster')
@section('title', 'Company (Customer)')

<!-- Vendor Style -->
@section('vendor-style')
    @vite(['resources/assets/vendor/libs/bs-stepper/bs-stepper.scss', 'resources/assets/vendor/libs/select2/select2.scss', 'resources/assets/vendor/libs/tagify/tagify.scss', 'resources/assets/vendor/libs/@form-validation/form-validation.scss'])
@endsection

<!-- Vendor Script -->
@section('vendor-script')
    @vite(['resources/assets/vendor/libs/cleave-zen/cleave-zen.js', 'resources/assets/vendor/libs/bs-stepper/bs-stepper.js', 'resources/assets/vendor/libs/select2/select2.js', 'resources/assets/vendor/libs/tagify/tagify.js', 'resources/assets/vendor/libs/@form-validation/popular.js', 'resources/assets/vendor/libs/@form-validation/bootstrap5.js', 'resources/assets/vendor/libs/@form-validation/auto-focus.js'])
@endsection

<!-- Page Script -->
@section('page-script')
    @vite(['resources/js/company/create.js'])
@endsection

@section('content')
    <!-- Property Listing Wizard -->
    <div id="wizard-property-listing" class="bs-stepper vertical mt-2">
        <div class="bs-stepper-header border-end">
            <div class="step" data-target="#personal-details">
                <button type="button" class="step-trigger">
                    <span class="bs-stepper-circle">
                        <i class="icon-base bx bx-user icon-md"></i>
                    </span>
                    <span class="bs-stepper-label">
                        <span class="bs-stepper-title">Personal Details</span>
                        <span class="bs-stepper-subtitle">Your Name/Email</span>
                    </span>
                </button>
            </div>
            <div class="line"></div>
            <div class="step" data-target="#company-details">
                <button type="button" class="step-trigger">
                    <span class="bs-stepper-circle">
                        <i class="icon-base bx bx-building-house icon-md"></i>
                    </span>
                    <span class="bs-stepper-label">
                        <span class="bs-stepper-title">Company Details</span>
                        <span class="bs-stepper-subtitle">Company Name/Phone</span>
                    </span>
                </button>
            </div>
            <div class="line"></div>
            <div class="step" data-target="#other-details">
                <button type="button" class="step-trigger">
                    <span class="bs-stepper-circle">
                        <i class="icon-base bx bx-star icon-md"></i>
                    </span>
                    <span class="bs-stepper-label">
                        <span class="bs-stepper-title">Other Details</span>
                        <span class="bs-stepper-subtitle">ABN/ACN No</span>
                    </span>
                </button>
            </div>
        </div>
        <div class="bs-stepper-content">
            <form id="wizard-property-listing-form" method="POST" action="{{ route('company-list.store') }}">
                @csrf
                <!-- Personal Details -->
                <div id="personal-details" class="content">
                    <div class="row g-6">
                        {{-- <input type="hidden" name="id" id="id"> --}}
                        <input type="hidden" name="company_id" value="{{ $company->id ?? '' }}" id="company_id">
                        <div class="col-sm-6 form-control-validation">
                            <label class="form-label" for="add-user-fname">First Name</label>
                            <input type="text" class="form-control" id="add-user-fname" name="fname" placeholder="John"
                                value="{{ isset($company->first_name) ? $company->first_name : old('fname') }}" required />
                        </div>
                        <div class="col-sm-6 form-control-validation">
                            <label class="form-label" for="add-user-lname">Last Name</label>
                            <input type="text" class="form-control" id="add-user-lname" name="lname" placeholder="Doe"
                                value="{{ isset($company->last_name) ? $company->last_name : old('lname') }}" required />
                        </div>
                        <div class="col-sm-6 form-control-validation">
                            <label class="form-label" for="add-user-email">Email</label>
                            <input type="email" id="add-user-email" class="form-control" name="email"
                                placeholder="john.doe@example.com"
                                value="{{ isset($company->email) ? $company->email : old('email') }}" required />
                        </div>
                        <div class="col-sm-6 form-password-toggle form-control-validation">
                            <label class="form-label" for="add-user-password">Password</label>
                            <div class="input-group input-group-merge">
                                <input type="password" id="add-user-password" class="form-control" name="password"
                                    placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                    aria-describedby="passwordToggler" />
                                <span id="passwordToggler" class="input-group-text cursor-pointer"><i
                                        class="icon-base bx bx-hide"></i></span>
                            </div>
                            @if (!empty($company->id))
                                <small class="text-muted">Leave blank to keep existing password (on edit).</small>
                            @endif
                        </div>
                        <div class="col-sm-6 form-password-toggle form-control-validation">
                            <label class="form-label" for="add-user-password">Confirm Password</label>
                            <div class="input-group input-group-merge">
                                <input type="password" id="add-user-password_confirmation" class="form-control"
                                    name="password_confirmation"
                                    placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                    aria-describedby="passwordToggler" />
                                <span id="passwordToggler" class="input-group-text cursor-pointer"><i
                                        class="icon-base bx bx-hide"></i></span>
                            </div>
                            @if (!empty($company->id))
                                <small class="text-muted">Leave blank to keep existing password (on edit).</small>
                            @endif
                        </div>
                        <div class="mb-6" style="display: none;">
                            <label class="form-label" for="user-role">User Role</label>
                            <select id="user-role" class="form-select" name="role" required>
                                @if (auth()->user()->hasRole('super_admin'))
                                    <option value="company">Company</option>
                                @elseif(auth()->user()->hasRole('admin'))
                                    <option value="company">Company</option>
                                @endif
                            </select>
                        </div>
                        <div class="col-12 d-flex justify-content-between">
                            <button type="button" class="btn btn-label-secondary btn-prev" disabled>
                                <i class="icon-base bx bx-left-arrow-alt scaleX-n1-rtl icon-sm me-sm-2 me-0"></i>
                                <span class="align-middle d-sm-inline-block d-none">Previous</span>
                            </button>
                            <button type="button" class="btn btn-primary btn-next">
                                <span class="align-middle d-sm-inline-block d-none me-sm-2">Next</span>
                                <i class="icon-base bx bx-right-arrow-alt icon-sm scaleX-n1-rtl"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- company Details -->
                <div id="company-details" class="content">
                    <div class="row">
                        <div class="form-control-validation mb-3">
                            <label class="form-label" for="add-company-fullname">Company Name</label>
                            <input type="text" class="form-control" id="add-company-fullname" name="companyname"
                                placeholder="Company Name"
                                value="{{ isset($company->name) ? $company->name : old('companyname') }}" />
                        </div>
                        <div class="form-control-validation mb-3">
                            <label class="form-label" for="add-trading-name">Trading Name</label>
                            <input type="text" class="form-control" id="add-trading-name" name="tradingname"
                                placeholder="Trading Name"
                                value="{{ isset($company->trading_name) ? $company->trading_name : old('tradingname') }}" />
                        </div>
                        <div class="form-control-validation mb-3">
                            <label class="form-label" for="add-phone">Phone</label>
                            <input type="text" id="add-phone" name="phone" class="form-control contact-number-mask"
                                placeholder="202 555 0111"
                                value="{{ isset($company->phone) ? $company->phone : old('phone') }}" />
                        </div>
                        {{-- <div class="col-lg-12 form-control-validation">
                            <label class="form-label" for="add-ho-address">HO Address</label>
                            <textarea name="hoaddress" id="add-ho-address" class="form-control" rows="2" placeholder="12, Business Park">{{ old('hoaddress',$company->ho_address??null) }}</textarea>
                        </div>
                        <div class="col-lg-12 form-control-validation mb-3">
                            <label class="form-label" for="add-address">Address</label>
                            <textarea id="add-address" name="address" class="form-control" rows="2" placeholder="12, Business Park">{{ old('address',$company->address??null) }}</textarea>
                        </div> --}}
                        <!-- Billing Address -->
                        <div class="col-lg-12">
                            <h5 class="mb-3">Billing Address</h5>
                        </div>

                        <div class="col-lg-6 form-control-validation">
                            <label class="form-label" for="billing-address-line1">Billing Address</label>
                            <input type="text" name="billing_address" id="billing-address" class="form-control"
                                placeholder="Street address"
                                value="{{ old('billing_address', $company->billing_address ?? null) }}">
                        </div>

                        <div class="col-lg-6 form-control-validation">
                            <label class="form-label" for="billing-state">State</label>
                            <input type="text" name="billing_state" id="billing-state" class="form-control"
                                placeholder="State" value="{{ old('billing_state', $company->billing_state ?? null) }}">
                        </div>

                        <div class="col-lg-6 form-control-validation">
                            <label class="form-label" for="billing-suburb">Suburb</label>
                            <input type="text" name="billing_suburb" id="billing-suburb" class="form-control"
                                placeholder="NSW" value="{{ old('billing_suburb', $company->billing_suburb ?? null) }}">
                        </div>

                        <div class="col-lg-6 form-control-validation mb-3">
                            <label class="form-label" for="billing-postcode">Post Code</label>
                            <input type="text" name="billing_postcode" id="billing-postcode" class="form-control"
                                placeholder="2000"
                                value="{{ old('billing_postcode', $company->billing_postcode ?? null) }}">
                        </div>


                        <!-- Delivery Address -->
                        <div class="col-lg-12">
                            <h5 class="mb-3">Delivery Address</h5>
                        </div>

                        <div class="col-lg-6 form-control-validation">
                            <label class="form-label" for="delivery-address-line1">Delivery Address</label>
                            <input type="text" name="delivery_address" id="delivery-address" class="form-control"
                                placeholder="Street address"
                                value="{{ old('delivery_address', $company->delivery_address ?? null) }}">
                        </div>

                        <div class="col-lg-6 form-control-validation">
                            <label class="form-label" for="delivery-state">State</label>
                            <input type="text" name="delivery_state" id="delivery-state" class="form-control"
                                placeholder="State"
                                value="{{ old('delivery_state', $company->delivery_state ?? null) }}">
                        </div>

                        <div class="col-lg-6 form-control-validation">
                            <label class="form-label" for="delivery-suburb">Suburb</label>
                            <input type="text" name="delivery_suburb" id="delivery-suburb" class="form-control"
                                placeholder="NSW"
                                value="{{ old('delivery_suburb', $company->delivery_suburb ?? null) }}">
                        </div>

                        <div class="col-lg-6 form-control-validation mb-3">
                            <label class="form-label" for="delivery-postcode">Post Code</label>
                            <input type="text" name="delivery_postcode" id="delivery-postcode" class="form-control"
                                placeholder="2000"
                                value="{{ old('delivery_postcode', $company->delivery_postcode ?? null) }}">
                        </div>
                        <div class="col-12 d-flex justify-content-between">
                            <button type="button" class="btn btn-label-secondary btn-prev">
                                <i class="icon-base bx bx-left-arrow-alt scaleX-n1-rtl icon-sm me-sm-2 me-0"></i>
                                <span class="align-middle d-sm-inline-block d-none">Previous</span>
                            </button>
                            <button type="button" class="btn btn-primary btn-next">
                                <span class="align-middle d-sm-inline-block d-none me-sm-2">Next</span>
                                <i class="icon-base bx bx-right-arrow-alt icon-sm scaleX-n1-rtl"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Other Features -->
                <div id="other-details" class="content">
                    <div class="row g-6">
                        <div class="col-sm-6 form-control-validation">
                            <label class="form-label d-block" for="website-url">Website URL</label>
                            <input type="url" id="website-url" name="websiteurl" class="form-control"
                                placeholder="https://example.com"
                                value="{{ isset($company->website_url) ? $company->website_url : old('websiteurl') }}" />
                        </div>
                        <div class="col-sm-6 form-control-validation">
                            <label class="form-label" for="abn-acn">ABN/ACN</label>
                            <input type="text" id="abn-acn" name="abnacn" class="form-control"
                                placeholder="202 555 0111"
                                value="{{ isset($company->abn_acn) ? $company->abn_acn : old('abnacn') }}" />
                        </div>
                        <div class="col-sm-6 form-control-validation">
                            <label class="form-label" for="add-company-platform">Platform</label>
                            <select id="add-company-platform" name="platform" class="form-select">
                                <option selected value="">Select Platform</option>
                                <option value="storage-provider"
                                    {{ isset($company->platform) && $company->platform == 'storage-provider' ? 'selected' : '' }}>
                                    Storage Provider</option>
                            </select>
                        </div>
                        <div class="col-sm-6 form-control-validation">
                            <label class="form-label" for="add-plan">Plan</label>
                            <select id="plan" name="plan" class="form-select">
                                <option selected value="">Select Plan</option>
                                <option value="basic"
                                    {{ isset($company->plan) && $company->plan == 'basic' ? 'selected' : '' }}>Basic
                                </option>
                                <option value="advance"
                                    {{ isset($company->plan) && $company->plan == 'advance' ? 'selected' : '' }}>Advance
                                </option>
                            </select>
                        </div>
                        <div class="col-sm-6 form-control-validation">
                            <label class="form-label" for="add-company-status">Status</label>
                            <select id="add-company-status" name="status" class="form-select">
                                <option value="active"
                                    {{ isset($company->status) && $company->status == 'active' ? 'selected' : '' }}>
                                    Active</option>
                                <option value="suspended"
                                    {{ isset($company->status) && $company->status == 'suspended' ? 'selected' : '' }}>
                                    Suspended</option>
                            </select>
                        </div>
                        <div class="col-12 d-flex justify-content-between">
                            <button type="button" class="btn btn-label-secondary btn-prev">
                                <i class="icon-base bx bx-left-arrow-alt scaleX-n1-rtl icon-sm me-sm-2 me-0"></i>
                                <span class="align-middle d-sm-inline-block d-none">Previous</span>
                            </button>
                            <button type="submit" class="btn btn-success btn-submit btn-next">Submit</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!--/ Property Listing Wizard -->

@endsection
