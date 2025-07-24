<?php

namespace App\Models\User;

use App\Models\Model;

class UserSettings extends Model {
  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
    'is_fto',
    'submission_count',
    'banned_at',
    'ban_reason',
    'birthday_setting',
    'strike_count',
    'selected_character_id',
    'allow_character_likes',
    'show_image_blocks',
    'border_settings',
    'deactivate_reason',
    'deactivated_at',
    'content_warning_visibility',
    'allow_profile_comments',
    'encounter_energy',
    'encounter_character_id',
  ];

  /**
   * The table associated with the model.
   *
   * @var string
   */
  protected $table = 'user_settings';

  /**
   * The attributes that should be cast to native types.
   *
   * @var array
   */
  protected $casts = [
    'banned_at'      => 'datetime',
    'deactivated_at' => 'datetime',
    'border_settings' => 'array',
  ];

  /**
   * The primary key of the model.
   *
   * @var string
   */
  public $primaryKey = 'user_id';

  /**********************************************************************************************

        RELATIONS

   **********************************************************************************************/

  /**
   * Get the user this set of settings belongs to.
   */
  public function user() {
    return $this->belongsTo('App\Models\User\User');
  }
  /**
   * Get the character the user has selected if appropriate.
   */
  public function selectedCharacter() {
    return $this->belongsTo('App\Models\Character\Character', 'selected_character_id')->visible();
  }

  /**
   * Get the character the user selected for encounters
   */
  public function encounterCharacter() {
    return $this->belongsTo('App\Models\Character\Character');
  }
}
