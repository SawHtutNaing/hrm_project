<?php

namespace Modules\FieldService\Entities;

use App\Models\BusinessUser;
use App\Models\settings\businessLocation;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FsCampaign extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    public $table = 'fscampaign';

    protected $fillable = [
        'name',
        'description',
        'location_name',
        'gps_location',
        'game_id',
        'questionnaire_id',
        'campaign_start_date',
        'campaign_end_date',
        'campaign_leader',
        'campaign_member',
        'status',
        'business_location_id',
        'created_by',
        'updated_by',
        'checkInPhoto',
    ];

    public function leader()
    {
        return $this->hasOne(BusinessUser::class, 'id', 'campaign_leader');
    }

    public function location()
    {
        return $this->hasOne(businessLocation::class, 'id', 'business_location_id');
    }
}
