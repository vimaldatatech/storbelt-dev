<?php

namespace App\Http\Controllers\company;

use App\Models\Company;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Validation\Rule;

class CompanyController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

        // View company list & details
        $this->middleware('permission.check:companies,view')
            ->only(['index', 'list', 'show', 'edit']);

        // Create company
        $this->middleware('permission.check:companies,create')
            ->only(['store', 'create']);

        // Update company
        $this->middleware('permission.check:companies,edit')
            ->only(['update']);

        // Delete company
        $this->middleware('permission.check:companies,delete')
            ->only(['destroy']);
    }

    public function index()
    {
        return view('company.company');
    }

    public function list(Request $request)
    {
        $companies = Company::leftJoin('users', 'users.id', '=', 'companies.user_id')
            ->select(
                'companies.id as id',
                'companies.name',
                'companies.phone',
                'companies.status',
                'companies.user_id',
                'users.email'
            )
            ->get();

        return response()->json(['data' => $companies]);
    }
    /* public function list(Request $request)
    {
        $comapny = Company::all();
        return response()->json(['data' => $comapny]);
    } */

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('company.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $companyId = $request->company_id;

        $validator = Validator::make($request->all(), [
            'companyname' => ['required',Rule::unique('companies', 'slug')->ignore($request->company_id)],
        ], [
            'companyname.required' => 'Company name is required.',
            'companyname.unique'   => 'Company "' . $request->companyname . '" already exists.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator->errors());
        }


        if ($companyId) {
            // update the value
            $user = User::updateOrCreate(
                ['email' => $request->email], // unique key
                [
                    'first_name' => $request->fname,
                    'last_name'  => $request->lname,
                    'email'      => $request->email,
                    'status'     => $request->status,
                    'password'   => Hash::make($request->password),
                ]
            );
            // Assign the role dynamically from the request
            if ($request->role) {
                $user->syncRoles([$request->role]);
            }
            $userId = $user['id'];
            $company = Company::updateOrCreate(
                ['id' => $companyId],
                [
                    'user_id'  => $userId,
                    'name' => $request->companyname,
                    'trading_name' => $request->tradingname,
                    'phone' => $request->phone,
                    // Billing Address
                    'billing_address'   => $request->billing_address,
                    'billing_state'      => $request->billing_state,
                    'billing_suburb'    => $request->billing_suburb,
                    'billing_postcode'  => $request->billing_postcode,

                    // Delivery Address
                    'delivery_address'  => $request->delivery_address,
                    'delivery_state'     => $request->delivery_state,
                    'delivery_suburb'   => $request->delivery_suburb,
                    'delivery_postcode' => $request->delivery_postcode,
                    'website_url' => $request->websiteurl,
                    'abn_acn' => $request->abnacn,
                    // 'code' => strtoupper($request->companycode),
                    'platform' => $request->platform,
                    'slug' => Str::slug($request->companyname),
                    'plan' => $request->plan,
                    'status' => $request->status,
                ]
            );


            // user updated
            return redirect()->route('company-list.index')->with('status', 'Company updated successfully');            
        } else {
            // create new one if slug is unique
            $companySlug = Company::where('slug', $request->slug)->first();

            if (empty($companySlug)) {
                $user = User::updateOrCreate(
                    ['email' => $request->email], // unique key
                    [
                        'first_name' => $request->fname,
                        'last_name'  => $request->lname,
                        'email'      => $request->email,
                        'password'   => Hash::make($request->password),
                        'status'     => $request->status,
                    ]
                );
                // Assign the role dynamically from the request
                if ($request->role) {
                    $user->syncRoles([$request->role]);
                }
                $userId = $user['id'];
                $company = Company::updateOrCreate(
                    ['id' => $companyId],
                    [
                        'user_id'  => $userId,
                        'name' => $request->companyname,
                        'trading_name' => $request->tradingname,
                        'phone' => $request->phone,
                        // Billing Address
                        'billing_address'   => $request->billing_address,
                        'billing_suburb'    => $request->billing_suburb,
                        'billing_state'      => $request->billing_state,
                        'billing_postcode'  => $request->billing_postcode,

                        // Delivery Address
                        'delivery_address'  => $request->delivery_address,
                        'delivery_suburb'   => $request->delivery_suburb,
                        'delivery_state'     => $request->delivery_state,
                        'delivery_postcode' => $request->delivery_postcode,
                        'website_url' => $request->websiteurl,
                        'abn_acn' => $request->abnacn,
                        // 'code' => strtoupper($request->companycode),
                        'platform' => $request->platform,
                        'slug' => Str::slug($request->companyname),
                        'plan' => $request->plan,
                        'status' => $request->status,
                    ]
                );

                // user created
                return redirect()->route('company-list.index')->with('status', 'Company added successfully');

            } else {
                return redirect()->back()->withInput()->withErrors(['companyname' => 'Company "' . $request->companyname . '" already exists.']);
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $company = Company::join('users', 'users.id', '=', 'companies.user_id')->where('companies.id', $id)->select(
            'companies.*',
            'users.first_name',
            'users.last_name',
            'users.email',
            'users.status as user_status'
        )->first(); // use first() since it's one company → one user

        // $user = Company::findOrFail($id);
        return view('company.create', compact('company'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {}

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $company = Company::findOrFail($id);

        // Delete the linked user if exists
        if ($company->user_id) {
            User::where('id', $company->user_id)->delete();
            User::where('parent_user_id', $company->user_id)->delete();
        }

        $company->delete();

        return response()->json(['message' => 'Company and linked user deleted successfully']);
    }
}
