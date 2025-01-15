<?php

namespace Modules\FieldService\Entities;

use App\Models\BusinessUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImageGallery extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    public $table = 'image_gallery';

    protected $fillable = ['note', 'images', 'campaign_id', 'created_by', 'updated_by'];

    public function user()
    {
        return $this->hasOne(BusinessUser::class, 'id', 'created_by');
    }

    public function campaign()
    {
        return $this->hasOne(FsCampaign::class, 'id', 'campaign_id');
    }
}
