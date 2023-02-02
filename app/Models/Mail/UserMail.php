<?php

namespace App\Models\Mail;

use Config;
use Carbon\Carbon;
use App\Models\Model;

use App\Traits\Commentable;

class UserMail extends Model
{
    use Commentable;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'sender_id', 'recipient_id', 'subject', 'message', 'seen'
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'user_mails';

    /**
     * Whether the model contains timestamps to be saved and updated.
     *
     * @var string
     */
    public $timestamps = true;

    /**
     * Validation rules for creation.
     *
     * @var array
     */
    public static $createRules = [
        'subject' => 'required|between:3,100',
        'message' => 'required',
    ];

    /**********************************************************************************************
    
        RELATIONS

    **********************************************************************************************/
    
    /**
     * Get the staff that sent the message
     */
    public function sender()
    {
        return $this->belongsTo('App\Models\User\User', 'sender_id');
    }

    /**
     * Get the user who was sent the message
     */
    public function recipient() 
    {
        return $this->belongsTo('App\Models\User\User');
    }

    /**********************************************************************************************
    
        ACCESSORS

    **********************************************************************************************/

    /**
     * Displays the message subject, linked to the message itself.
     *
     * @return string
     */
    public function getDisplayNameAttribute()
    {
        return '<a href="'.$this->url.'">'.$this->subject.'</a>';
    }

    /**
     * Gets the message URL.
     *
     * @return string
     */
    public function getViewUrlAttribute()
    {
        return url('inbox/view/'.$this->id);
    }
}
