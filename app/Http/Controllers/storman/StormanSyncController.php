<?php

namespace App\Http\Controllers\storman;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\CustomerFacility;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StormanSyncController extends Controller
{
    public function index()
    {
        $company = Company::where('user_id', Auth::id())->first();
        $facilities = CustomerFacility::where('user_id', Auth::id())->orderBy('name', 'asc')->get();

        return view('storman.index', compact('company', 'facilities'));
    }

    public function save(Request $request)
    {
        $request->validate([
            'api_url' => 'required|url',
            'token' => 'required|string',
        ]);

        $company = Company::where('user_id', Auth::id())->firstOrFail();

        $company->update([
            'storman_api_url' => $request->api_url,
            'storman_api_token' => $request->token,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Storage Provider settings saved successfully',
        ]);
    }

    public function sync(Request $request)
    {
        $request->validate([
            'api_url' => 'required|url',
            'token' => 'required|string',
        ]);

        $user = auth()->user();

        try {

            CustomerFacility::syncWithStorman($user->id, $request->api_url, $request->token);

            $userUpdate = User::find($user->id);
            if ($userUpdate) {
                $userUpdate->last_data_sync = now();
                $userUpdate->save();
            }

            return response()->json([
                'status' => true,
                'message' => 'Facilities synced successfully!',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Sync failed: '.$e->getMessage(),
            ], 500);
        }
    }
}
