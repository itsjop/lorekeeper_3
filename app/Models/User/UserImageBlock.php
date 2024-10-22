<?php

namespace App\Models\User;

use App\Models\Model;
use App\Models\User\User;

class UserImageBlock extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'object_id', 'object_type', 'user_id',
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'user_image_blocks';

    /**********************************************************************************************

    RELATIONS

     **********************************************************************************************/

    /**
     * Get the blocked object.
     */
    public function object()
    {
        return $this->morphTo();
    }

    /**
     * Get the user who blocked the image.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Switch the image being checked for (in certain cases)
     */
    public function objectImageUrl()
    {
        if ($this->object->currencyImageUrl) {
            return $this->object->currencyImageUrl;
        } elseif ($this->object->avatarUrl) {
            return $this->object->avatarUrl;
        } elseif ($this->object->thumbnailUrl) {
            return $this->object->thumbnailUrl;
        }
        return $this->object->imageUrl;
    }

    public function objectDisplayName()
    {
        if ($this->object->displayName) {
            return $this->object->displayName;
        }
        return $this->object->displayName;
    }

    public function objectUrl()
    {
        if ($this->object->idUrl) {
            return $this->object->idUrl;
        }
        return $this->object->url;
    }

}
