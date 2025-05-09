<?php
namespace App\Models\User;
use App\Models\Model;

class UserLocalSettings extends Model {
  /** The attributes that are mass assignable. */
  protected $fillable = ['high_contrast', 'reduced_motion', 'site_font', 'light_dark', 'theme', 'pinned_menu_items'];

  /** The table associated with the model. */
  protected $table = 'user_local_settings';

  /** The attributes that should be cast to native types */
  protected $casts = [
    'high_contrast' => 'boolean',
    'reduced_motion' => 'boolean',
    'light_dark' => 'boolean',
    'site_font' => 'string',
    'pinned_menu_items' => 'string',
    'theme' => 'string',
  ];

  /** The primary key of the model. */
  public $primaryKey = 'user_id';

  /* Get the user this set of settings belongs to. */
  public function user() {
    return $this->belongsTo('App\Models\User\User');
  }
}
