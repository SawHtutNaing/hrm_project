<?php

use Modules\FieldService\Entities\attendanceRecords;

function hourDiffFromDate($date1, $date2)
{
    $datetime1 = new DateTime($date1);
    $datetime2 = new DateTime($date2);
    $interval = $datetime1->diff($datetime2);
    $totalHours = $interval->days * 24 + $interval->h + $interval->i / 60;

    return $totalHours;
}
function isCheckIn($campaignId, $employeeId)
{
    $check = attendanceRecords::where('campaign_id', $campaignId)
        ->where('employee_id', $employeeId)
        ->whereDate('checkin_datetime', now()->format('Y-m-d'))
        ->exists();

    return $check;
}

function isCheckOut($campaignId, $employeeId)
{
    $check = attendanceRecords::where('campaign_id', $campaignId)
        ->where('employee_id', $employeeId)
        ->whereDate('checkout_datetime', now()->format('Y-m-d'))
        ->exists();

    return $check;
}

function getStatus($campaignId, $employeeId)
{
    $check = optional(attendanceRecords::where('campaign_id', $campaignId)
        ->where('employee_id', $employeeId)
        ->orderBy('id', 'DESC')
        ->first())->status;

    return $check;
}

function businessaddress($address)
{
    // dd($address);
    return arr($address, 'address', ', ').arr($address, 'city', ',').arr($address, 'state', ', ').arr($address, 'country', ' ').'<br>'.
        arr($address, 'zip_postal_code', '.').'<br>'.
        arr($address, 'mobile', ',').arr($address, 'alternate_number', '.').'<br>'.
        arr($address, 'email', '.');
}

function hasPlay($feature)
{
    return checkPermission($feature, 'play');
}

function hasShare($feature)
{
    return checkPermission($feature, 'share');
}
