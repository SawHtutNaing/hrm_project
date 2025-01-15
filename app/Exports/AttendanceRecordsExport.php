<?php

namespace App\Exports;

use App\Models\AttendanceRecords;
use Maatwebsite\Excel\Concerns\FromCollection;

class AttendanceRecordsExport implements FromCollection
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return AttendanceRecords::all();
    }
}
