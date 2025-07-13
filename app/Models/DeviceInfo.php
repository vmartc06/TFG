<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class DeviceInfo extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'devices_info';

    protected $fillable = [
        'board_name',
        'bootloader',
        'brand',
        'device',
        'android_build_sdk',
        'android_build_display',
        'android_build_fingerprint',
        'android_build_timestamp_ms',
        'android_build_type',
        'android_build_user',
        'android_build_tags',
        'hardware_name',
        'host',
        'device_identifier',
        'manufacturer',
        'model',
        'odm_sku',
        'product_name',
        'serial',
        'sku',
        'soc_manufacturer',
        'soc_model',
        'supported_32_bit_abis',
        'supported_64_bit_abis',
        'supported_abis',
        'device_id'
    ];

    protected $casts = [
        'android_build_timestamp_ms' => 'integer',
        'supported_32_bit_abis' => 'array',
        'supported_64_bit_abis' => 'array',
        'supported_abis' => 'array',
        'device_id' => 'integer'
    ];

    // Custom methods

    public function getAndroidVersion(): string
    {
        return match ((int)$this->android_build_sdk) {
            36 => '16',
            35 => '15',
            34 => '14',
            33 => '13',
            32 => '12L',
            31 => '12',
            30 => '11',
            29 => '10',
            28 => '9',
            27 => '8.1',
            26 => '8.0',
            25 => '7.1',
            24 => '7.0',
            23 => '6.0',
            22 => '5.1',
            21 => '5.0',
            default => 'Unknown',
        };
    }

}