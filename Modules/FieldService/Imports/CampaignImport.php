<?php

namespace Modules\FieldService\Imports;

use App\Models\BusinessUser;
use App\Models\settings\businessLocation;
use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Modules\FieldService\Entities\FsCampaign;
use Modules\FieldService\Entities\Questionnaires;
use Modules\Games\Entities\Spinwheel;

class CampaignImport implements ToCollection, WithBatchInserts, WithChunkReading, WithHeadingRow, WithValidation
{
    use Importable;

    private $imageCoordinates = [];

    private $rowCount;

    public function __construct()
    {

        ini_set('max_execution_time', '0');
        ini_set('memory_limit', '-1');
        ini_set('max_allowed_packet', '-1');

    }

    public function collection(Collection $rows)
    {
        try {
            DB::beginTransaction();
            $chunkedRows = $rows->chunk(100);
            foreach ($chunkedRows as $rows) {
                foreach ($rows as $row) {
                    $data = $this->prepareData($row);
                    FsCampaign::create($data);
                }
            }

            DB::commit();

            return back()->with(['success' => 'Successfully Imported']);
        } catch (\Throwable $th) {
            DB::rollBack();

            return throw new Exception($th->getMessage());
            // throw $th;
        }
    }

    public function prepareData($row)
    {

        // dd($row->toArray());

        $formattedStartDate = $row['start_date'] ? $this->formatDate($row['start_date']) : null;
        $formattedEndDate = $row['end_date'] ? $this->formatDate($row['end_date']) : null;

        $outletId = businessLocation::where('name', rtrim($row['outlet_name']))->select('id')->first()->id;
        $memberNames = $this->splitMemberStringToArray($row['campaign_member']);
        $leaderId = BusinessUser::where('username', rtrim($row['campaign_leader']))->select('id')->first()->id;

        $members = BusinessUser::whereIn('username', $memberNames)->select('id')->get()->pluck('id')->toArray() ?? ['all'];
        $gameId = Spinwheel::where('name', $row['game_template_name'])->select('id')->first()->id ?? null;
        $questionnaireId = Questionnaires::where('name', $row['questionnaires'])->select('id')->first()->id ?? null;
        // dd($row['questionnaires'],$questionnaireId);
        $members = json_encode($members);

        return [
            'business_location_id' => $outletId,
            'name' => $row['campaign_name'],
            'game_id' => $gameId,
            'questionnaire_id' => $questionnaireId,
            'campaign_start_date' => $formattedStartDate,
            'campaign_end_date' => $formattedEndDate,
            'campaign_leader' => $leaderId,
            'campaign_member' => $members,
            'description' => $row['description'],
        ];
    }

    public function formatDate($date)
    {
        $excelDateValue = intval($date);
        $unixTimestamp = ($excelDateValue - 25569) * 86400;

        return date('Y-m-d', $unixTimestamp);
    }

    public function chunkSize(): int
    {
        return 500;
    }

    public function batchSize(): int
    {
        return 500;
    }

    public function rules(): array
    {

        return [
            // '*.outlet_name' => [
            //     'required'
            // ],
            '*.outlet_name' => [
                'required',
                function ($attribute, $value, $fail) {
                    $value = rtrim($value);
                    $checkLocation = businessLocation::where('name', $value)->exists();
                    if (! $checkLocation) {
                        $fail('The  outlet name "'.$value.'"  not found.');
                    }
                },
            ],
            '*.campaign_leader' => [
                'required',
                function ($attribute, $value, $fail) {
                    $value = rtrim($value);
                    $checkLocation = BusinessUser::where('username', $value)->exists();
                    if (! $checkLocation) {
                        $fail('The  campaing leader name "'.$value.'"  not found.');
                    }
                },
            ],
            '*.campaign_member' => [
                'nullable',
                function ($attribute, $value, $fail) {
                    $splitValues = $this->splitMemberStringToArray($value);
                    foreach ($splitValues as $splitValue) {
                        $checkLocation = BusinessUser::where('username', $splitValue)->exists();
                        if (! $checkLocation && strtolower($splitValue) != 'all') {
                            $fail('The  campaing member name "'.$splitValue.'"  not found.');
                        }
                    }
                },
            ],
            '*.game_template_name' => [
                'nullable',
                function ($attribute, $value, $fail) {
                    $value = rtrim($value);
                    $check = Spinwheel::where('name', $value)->exists();
                    if (! $check) {
                        $fail('The  Game Template "'.$value.'"  not found.');
                    }
                },
            ],
            '*.questionnaires' => [
                'nullable',
                function ($attribute, $value, $fail) {
                    $value = rtrim($value);
                    $check = Questionnaires::where('name', $value)->exists();
                    if (! $check) {
                        $fail('The  Questionnaires "'.$value.'"  not found.');
                    }
                },
            ],

        ];
    }

    public function customValidationMessages()
    {
        return [
            '*.location_name.required' => 'Location Name is Required.',
            '*.inventory_flow.required' => 'Inventory Flow is Required.',
            '*.location_type.iin' => 'Location Type is Invalid.',
        ];
    }

    public function splitMemberStringToArray(string $value)
    {
        $value = rtrim($value);

        return explode('|', $value);
    }
}
