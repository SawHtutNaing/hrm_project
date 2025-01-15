<?php

namespace Modules\FieldService\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\sale\sale_details;
use App\Services\file\FileServices;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\FieldService\Entities\attendanceRecords;
use Modules\FieldService\Entities\FsCampaign;
use Yajra\DataTables\Facades\DataTables;

class AttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $campaigns = FsCampaign::select('id', 'name')->get();

        return view('fieldservice::attendance.index', compact('campaigns'));
    }

    public function checkInForm(FsCampaign $campaign)
    {

        $campaignMemberId = json_decode($campaign->campaign_member);
        if ($campaign->status != 'start') {
            return redirect()->route('campaign.index')->with(['warning' => 'Campaign Not Start']);
        } elseif ($campaignMemberId[0] != 'all' && ! $campaign->whereJsonContains('campaign_member', Auth::user()->id)->exists() && ! $campaign->where('campaign_leader', Auth::user()->id)->exists()) {
            return redirect()->route('campaign.index')->with(['error' => '403. No permission to this campaign']);
        } else {
            return view('fieldservice::attendance.checkIn', compact('campaign'));
        }
    }

    public function checkIn(FsCampaign $campaign, Request $request)
    {

        $campaignMemberId = json_decode($campaign->campaign_member);
        if ($campaign->status != 'start') {
            return redirect()->route('campaign.index')->with(['warning' => 'Campaign Not Start']);
        } elseif ($campaignMemberId[0] != 'all' && ! $campaign->whereJsonContains('campaign_member', Auth::user()->id)->exists() && ! $campaign->where('campaign_leader', Auth::user()->id)->exists()) {
            return redirect()->route('campaign.index')->with(['error' => '403. No permission to this campaign']);
        } else {

            try {
                if ($request->hasFile('checkInPhoto')) {
                    $fileName = FileServices::upload($request->file('checkInPhoto'), 'checkIn/', 'ts');
                } else {
                    $message = __('fieldservice::campaign.photo_is_required');

                    return back()->with('error', $message);
                }

                attendanceRecords::create(
                    [
                        'location_name' => $request->location_name,
                        'campaign_id' => $campaign->id,
                        'employee_id' => Auth::user()->id,
                        'gps_location' => $request->gps_location,
                        'checkin_datetime' => now(),
                        'photo' => json_encode(['checkIn' => $fileName]),
                        'status' => 'checkIn',
                    ]
                );

                return redirect()->route('campaign.index')->with('success', 'Successfuly CheckIn');
            } catch (\Throwable $th) {
                return back()->with('error', $th->getMessage());
            }
        }

    }

    public function checkOutForm(FsCampaign $campaign)
    {
        $attendanceRecord = attendanceRecords::where('employee_id', Auth::user()->id)
            ->where('campaign_id', $campaign->id)
            ->where('status', 'checkIn')
            ->orderBy('id', 'DESC')
            ->first();
        $checkinDatetime = $attendanceRecord['checkin_datetime'];
        $sales = sale_details::select('sales.id', 'sales.sales_voucher_no', 'sale_details.variation_id', 'sale_details.quantity', 'sale_details.uom_id', 'sale_details.subtotal_with_discount')
            ->leftJoin('sales', 'sales.id', '=', 'sale_details.sales_id')
            ->with('uom:id,short_name')
            ->where('sales.sold_by', Auth::user()->id)
            ->where('channel_id', $campaign->id)
            ->where('channel_type', 'campaign')
            ->where('sales.sold_at', '<=', now())
            ->where('sales.sold_at', '>=', $checkinDatetime)
            ->orderBy('sale_details.id', 'DESC')->paginate(20);

        return view('fieldservice::attendance.checkOut', compact('campaign', 'attendanceRecord', 'sales'));
    }

    public function checkOut(FsCampaign $campaign, Request $request)
    {
        try {
            $record = attendanceRecords::where('id', $request->attendanceId)->first();
            if ($request->hasFile('checkOutPhoto')) {
                $fileName = FileServices::upload($request->file('checkOutPhoto'), 'checkOut/', 'ts');
            } else {
                $message = __('fieldservice::campaign.photo_is_required');

                return back()->with('error', $message);
            }
            $photoData = json_decode($record->photo, true);
            $photoData['checkOut'] = $fileName;
            $record->update([
                'checkout_location_name' => $request->checkout_location_name,
                'checkout_gps_location' => $request->checkout_gps_location,
                'checkout_datetime' => $request->checkout_datetime,
                'hours_worked' => $request->hours_worked,
                'status' => 'checkOut',
                'photo' => json_encode($photoData),
            ]);

            return redirect()->route('campaign.index')->with('success', 'Successfuly check out');
        } catch (\Throwable $th) {
            dd($th->getMessage());
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('fieldservice::create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        //
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('fieldservice::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('fieldservice::edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id): RedirectResponse
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
    }

    public function getAttendance(Request $record)
    {
        $campaignId = $record->campaign_id ?? null;
        $attendanceRecord = attendanceRecords::select('attendance_records.*', 'business_users.username as employee', 'fscampaign.name as campaign')
            ->leftJoin('business_users', 'business_users.id', '=', 'attendance_records.employee_id')
            ->leftJoin('fscampaign', 'fscampaign.id', '=', 'attendance_records.campaign_id')
            ->orderBy('attendance_records.id', 'DESC');
        if ($campaignId) {
            $attendanceRecord = $attendanceRecord->where('fscampaign.id', $campaignId);
        }

        return DataTables::of($attendanceRecord)
            ->addColumn('attendance_photo', function ($ar) {
                if ($ar->photo) {
                    $photo = json_decode($ar->photo);
                    $src = asset('/storage/checkIn/'.$photo->checkIn);
                    $html = '<div class="w-100 min-h-50px ps-2 text-center">
                                <a class="d-block m-auto overlay w-50px h-50px" data-fslightbox="lightbox-basic-'.$ar->id.'" href="'.$src.'">
                                    <div data-src="'.$src.'" class="overlay-wrapper bgi-no-repeat bg-gray-300 bgi-position-center bg-secondary bgi-size-cover card-rounded  w-50px h-50px lazy-bg"
                                        style="background-image:url('.$src.'); background-color:gray;">
                                    </div>
                                    <div class="overlay-layer card-rounded bg-dark bg-opacity-25 shadow ">
                                        <i class="bi bi-eye-fill text-white fs-5"></i>
                                    </div>
                                </a>
                            </div>';

                    return $html;
                }

                return '';
            })
            ->editColumn('checkin_datetime', function ($ar) {
                return fdate($ar->checkin_datetime, false);
            })
            ->editColumn('checkout_datetime', function ($ar) {
                return fdate($ar->checkout_datetime, false);
            })
            ->editColumn('status', function ($ar) {
                if ($ar->status == 'checkIn') {
                    return '
                            <span class="text-success">'.$ar->status.'</span>
                        ';
                } else {
                    return '
                            <span class="text-danger">'.$ar->status.'</span>
                        ';
                }
            })
            ->rawColumns(['status', 'attendance_photo'])
            ->make(true);
    }
}
