<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Device;
use App\Models\DeviceSlot;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Psy\Util\Json;
use function Psy\debug;

class DevicesController extends Controller
{

    public function add(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('devices')->where(function ($query) use ($request) {
                return $query->where('user_id', auth()->id());
            })],
        ]);

        $user = $request->user();

        $device = Device::create([
            'name' => $validated['name'],
            'enrollment_code' => self::generateEnrollmentCode(),
            'user_id' => $user->id
        ]);

        $device->slots()->delete();
        $device->info()->delete();
        $device->api_key_encrypted = null;
        $device->enrollment_code = self::generateEnrollmentCode();
        $device->save();

        $enrollmentData = $this->generateEnrollmentData($device->enrollment_code);

        if (empty($enrollmentData)) {
            return response()->json([], 500);
        }

        return response()->json($enrollmentData);
    }

    public function list(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'enrolled' => ['nullable', 'boolean']
        ]);

        $user = $request->user();
        $devices = Device::where('user_id', $user->id)->whereNotNull('enrollment_code');
        if (isset($validated['enrolled']) && $validated['enrolled']) {
            $devices = Device::where('user_id', $user->id)->whereNull('enrollment_code');
        }

        return response()->json($devices->get());
    }

    public function change(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'device_id' => ['required', 'integer', 'exists:devices,id']
        ]);

        $user = $request->user();

        $device = Device::where('id', $validated['device_id'])
            ->where('user_id', $user->id)
            ->first();

        if ($device->user_id != $user->id) {
            return response()->json([], 401);
        }

        $device->slots()->delete();
        $device->info()->delete();
        $device->api_key_encrypted = null;
        $device->enrollment_code = self::generateEnrollmentCode();
        $device->save();

        $enrollmentData = $this->generateEnrollmentData($device->enrollment_code);

        if (empty($enrollmentData)) {
            return response()->json([], 500);
        }

        return response()->json($enrollmentData);
    }

    private function generateEnrollmentData(string $enrollmentCode): array
    {
        $appPath = public_path('app.apk');
        if (!file_exists($appPath)) {
            Log::error("Could not find the Device Owner app on $appPath");
            return [];
        }
        $appHash = hash_file('sha256', $appPath, true);
        $appChecksum = rtrim(strtr(base64_encode($appHash), '+/', '-_'), '=');

        $appComponentName = env('APP_COMPONENT_NAME', null);
        if ($appComponentName == null) {
            Log::error("Could not find APP_COMPONENT_NAME in environment variable");
            return [];
        }

        return [
            "android.app.extra.PROVISIONING_DEVICE_ADMIN_COMPONENT_NAME" => $appComponentName,
            "android.app.extra.PROVISIONING_DEVICE_ADMIN_PACKAGE_CHECKSUM" => $appChecksum,
            "android.app.extra.PROVISIONING_DEVICE_ADMIN_PACKAGE_DOWNLOAD_LOCATION" => asset('app.apk'),
            "android.app.extra.PROVISIONING_SKIP_ENCRYPTION" => "true",
            "android.app.extra.PROVISIONING_LEAVE_ALL_SYSTEM_APPS_ENABLED" => "true",
            "android.app.extra.PROVISIONING_ADMIN_EXTRAS_BUNDLE" => [
                "server_url" => url('api/v1'),
                "registration_code" => $enrollmentCode
            ]
        ];
    }

    public function delete(Request $request): Response | JsonResponse
    {
        $validated = $request->validate([
            'device_id' => ['required', 'integer', 'exists:devices,id']
        ]);

        $user = $request->user();

        $device = Device::where('id', $validated['device_id'])
            ->where('user_id', $user->id)
            ->first();

        if ($device->user_id != $user->id) {
            return response()->json([], 401);
        }

        $device->delete();

        return response()->noContent();
    }

    /**
     * @throws ValidationException
     */
    public function enroll(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'enrollment_code' => ['required', 'string', 'max:10', 'exists:devices,enrollment_code'],
            'dpm_enrollment_id' => 'present|nullable|string|max:255',
            'build.board_name' => 'present|nullable|string|max:255',
            'build.bootloader' => 'present|nullable|string|max:255',
            'build.brand' => 'present|nullable|string|max:255',
            'build.device' => 'present|nullable|string|max:255',
            'build.android_build_info' => 'present|nullable|array',
            'build.android_build_info.sdk' => 'present|nullable|integer',
            'build.android_build_info.display' => 'present|nullable|string',
            'build.android_build_info.fingerprint' => 'present|nullable|string',
            'build.android_build_info.timestamp_ms' => 'present|nullable|integer',
            'build.android_build_info.type' => 'present|nullable|string|max:255',
            'build.android_build_info.user' => 'present|nullable|string|max:255',
            'build.android_build_info.tags' => 'present|nullable|string|max:255',
            'build.hardware_name' => 'present|nullable|string|max:255',
            'build.host' => 'present|nullable|string|max:255',
            'build.id' => 'present|nullable|string|max:255',
            'build.manufacturer' => 'present|nullable|string|max:255',
            'build.model' => 'present|nullable|string|max:255',
            'build.odm_sku' => 'present|nullable|string|max:255',
            'build.product_name' => 'present|nullable|string|max:255',
            'build.serial' => 'present|nullable|string|max:255',
            'build.sku' => 'present|nullable|string|max:255',
            'build.soc_manufacturer' => 'present|nullable|string|max:255',
            'build.soc_model' => 'present|nullable|string|max:255',
            'build.supported_32_bit_abis' => 'present|array',
            'build.supported_32_bit_abis.*' => 'string',
            'build.supported_64_bit_abis' => 'present|array',
            'build.supported_64_bit_abis.*' => 'string',
            'build.supported_abis' => 'present|array',
            'build.supported_abis.*' => 'string',
            'slots' => 'present|array',
            'slots.*.id' => 'present|nullable|string|max:255',
            'slots.*.subscriberID' => 'present|nullable|string|max:255',
            'slots.*.simSerial' => 'present|nullable|string|max:255',
            'slots.*.networkOperator' => 'present|nullable|string|max:255',
            'slots.*.networkOperatorName' => 'present|nullable|string|max:255',
            'slots.*.simState' => 'present|integer',
            'slots.*.phoneType' => 'present|integer',
            'slots.*.imei' => 'present|nullable|string|max:255',
            'slots.*.meid' => 'present|nullable|string|max:255'
        ]);

        $build = $validated['build'];

        $device = Device::where('enrollment_code', $validated['enrollment_code'])
            ->first();

        $deviceInfo = [
            "board_name" => $build['board_name'],
            "bootloader" => $build['bootloader'],
            "brand" => $build['brand'],
            "device" => $build['device'],
            "android_build_sdk" => $build['android_build_info']['sdk'],
            "android_build_display" => $build['android_build_info']['display'],
            "android_build_fingerprint" => $build['android_build_info']['fingerprint'],
            "android_build_timestamp_ms" => $build['android_build_info']['timestamp_ms'],
            "android_build_type" => $build['android_build_info']['type'],
            "android_build_user" => $build['android_build_info']['user'],
            "android_build_tags" => $build['android_build_info']['tags'],
            "hardware_name" => $build['hardware_name'],
            "host" => $build['host'],
            "device_identifier" => $build['id'],
            "manufacturer" => $build['manufacturer'],
            "model" => $build['model'],
            "odm_sku" => $build['odm_sku'],
            "product_name" => $build['product_name'],
            "serial" => $build['serial'],
            "sku" => $build['sku'],
            "soc_manufacturer" => $build['soc_manufacturer'],
            "soc_model" => $build['soc_model'],
            "supported_32_bit_abis" => $build['supported_32_bit_abis'],
            "supported_64_bit_abis" => $build['supported_64_bit_abis'],
            "supported_abis" => $build['supported_abis']
        ];

        $apiKey = self::generateApiKey($validated);

        $device->info()->create($deviceInfo);

        foreach ($validated['slots'] as $slot) {
            $slotDB = [
                'slotID' => $slot['id'],
                'subscriberID' => $slot['subscriberID'],
                'networkOperator' => $slot['networkOperator'],
                'networkOperatorName' => $slot['networkOperatorName'],
                'simState' => $slot['simState'],
                'phoneType' => $slot['phoneType'],
                'imei' => $slot['imei'],
                'meid' => $slot['meid']
            ];
            $device->slots()->create($slotDB);
        }
        $device->enrollment_code = null;
        $device->api_key_encrypted = Hash::make($apiKey);
        $device->save();

        return response()->json([
            "api_key" => $apiKey
        ]);
    }

    private static function generateApiKey($validated): string
    {
        $apiKey = "";

        // Use IMEI/MEID if available
        $slots = $validated['slots'];
        foreach ($slots as $slot) {
            $imei = $slot['imei'];
            $meid = $slot['meid'];
            if ($imei == null && $meid == null) continue;
            if ($slot['phoneType'] == DeviceSlot::PHONE_TYPE_GSM) {
                $apiKey .= $imei;
            } else {
                $apiKey .= $meid;
            }
        }

        if (!empty($apiKey)) return $apiKey;

        // Use DPM enrollment id

        if (!empty($validated['dpm_enrollment_id'])) {
            return $validated['dpm_enrollment_id'];
        }

        // Use build board name, brand, device, hardware_name and host
        $apiKey .= $validated['build']['board_name'];
        $apiKey .= $validated['build']['brand'];
        $apiKey .= $validated['build']['device'];
        $apiKey .= $validated['build']['hardware_name'];
        $apiKey .= $validated['build']['host'];

        if (!empty($apiKey)) return $apiKey;

        Log::warning("Could not generate an optimal key, generating random key");
        for ($i=0; $i<10; $i++) {
            $apiKey .= self::generateEnrollmentCode();
        }

        return $apiKey;
    }

    private static function generateEnrollmentCode(): string
    {
        $code = "";
        for ($i=0; $i<5; $i++) {
            $chars = "ABCDEF0123456789";
            for ($j=0; $j<10; $j++) {
                $code .= $chars[rand(0, strlen($chars)-1)];
            }
            Log::debug("Trying enrollment code [$code]");
            $device = Device::where('enrollment_code', $code)->first();
            if (!$device) return $code;
        }
        Log::error("Could not generate enrollment code. Exceeded 5 attempts. Latest code was [$code]");
        abort(500);
    }
}