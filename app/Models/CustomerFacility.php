<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class CustomerFacility extends Model
{
    use HasFactory;

    protected $table = 'customer_facilities';

    protected $fillable = [
        'api_id', 'user_id', 'code', 'is_active', 'group', 'name', 'short_name',
        'company_name', 'business_name', 'phone', 'email', 'address', 'suburb', 'city',
        'region', 'region_code', 'country_code', 'post_code', 'latitude', 'longitude',
        'trading_hours', 'facility_features', 'custom_fields',
    ];

    public static function syncWithStorman($user_id, $api_url, $api_token)
    {
        Log::info("Start syncing facilities for user_id: $user_id");

        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer '.$api_token,
                'Accept' => 'application/json',
            ])->withoutVerifying() // <- disables SSL check
                ->get($api_url.'/api/v1/company/facilities');

            if ($response->failed()) {
                throw new \Exception('Failed to fetch facilities from Storage Provider.');
            }

            $facilities = $response->json();

            if (empty($facilities)) {
                return false;
            }

            $existing_codes = self::where('user_id', $user_id)->pluck('code')->toArray();
            $insert_batch = [];
            $time = Carbon::now();

            foreach ($facilities as $f) {
                $data = [
                    'api_id' => $f['id'] ?? null,
                    'user_id' => $user_id,
                    'code' => $f['code'] ?? null,
                    'is_active' => $f['is_active'] ?? true,
                    'group' => $f['group'] ?? null,
                    'name' => $f['name'] ?? null,
                    'short_name' => $f['short_name'] ?? null,
                    'company_name' => $f['company_name'] ?? null,
                    'business_name' => $f['business_name'] ?? null,
                    'phone' => $f['phone'] ?? null,
                    'email' => $f['email'] ?? null,
                    'address' => $f['address'] ?? null,
                    'suburb' => $f['suburb'] ?? $f['short_name'] ?? null,
                    'city' => $f['city'] ?? null,
                    'region' => $f['region'] ?? null,
                    'region_code' => $f['region_code'] ?? null,
                    'country_code' => $f['country_code'] ?? null,
                    'post_code' => $f['post_code'] ?? null,
                    'latitude' => $f['latitude'] ?? null,
                    'longitude' => $f['longitude'] ?? null,
                    'trading_hours' => isset($f['trading_hours']) ? json_encode($f['trading_hours']) : null,
                    'facility_features' => isset($f['facility_features']) ? json_encode($f['facility_features']) : null,
                    'custom_fields' => isset($f['custom_fields']) ? json_encode($f['custom_fields']) : null,
                    'updated_at' => $time,
                ];

                if (isset($f['code']) && in_array($f['code'], $existing_codes)) {
                    self::where('user_id', $user_id)->where('code', $f['code'])->update($data);
                } else {
                    $data['created_at'] = $time;
                    $insert_batch[] = $data;
                }
            }

            if (! empty($insert_batch)) {
                self::insert($insert_batch);
            }

            Log::info("Finished syncing facilities for user_id: $user_id");

            return true;

        } catch (\Exception $e) {
            Log::error("Error syncing facilities for user_id: $user_id - ".$e->getMessage());

            return false;
        }
    }
}
