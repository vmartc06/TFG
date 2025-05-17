<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Notifications\Notifiable;

class DeviceSlot extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'devices_slots';

    const PHONE_TYPE_NONE = 0;
    const PHONE_TYPE_GSM = 1;
    const PHONE_TYPE_CDMA = 2;
    const PHONE_TYPE_SIP = 3;


    const SIM_STATE_UNKNOWN = 0;
    const SIM_STATE_ABSENT = 1;
    const SIM_STATE_PIN_REQUIRED = 2;
    const SIM_STATE_PUK_REQUIRED = 3;
    const SIM_STATE_NETWORK_LOCKED = 4;
    const SIM_STATE_READY = 5;
    const SIM_STATE_NOT_READY = 6;
    const SIM_STATE_PERM_DISABLED = 7;
    const SIM_STATE_CARD_IO_ERROR = 8;
    const SIM_STATE_CARD_RESTRICTED = 9;

    protected $fillable = [
        'slotID',
        'subscriberID',
        'networkOperator',
        'networkOperatorName',
        'simState',
        'phoneType',
        'imei',
        'meid',
        'device_id'
    ];

    public function device(): BelongsTo
    {
        return $this->belongsTo(Device::class);
    }
}