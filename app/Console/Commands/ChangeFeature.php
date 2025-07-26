<?php

namespace App\Console\Commands;

use DB;
use Settings;
use Log;
use Illuminate\Console\Command;
use App\Models\Character\Character;

class ChangeFeature extends Command {
  /**
   * The name and signature of the console command.
   *
   * @var string
   */
  protected $signature = 'change-feature';

  /**
   * The console command description.
   *
   * @var string
   */
  protected $description = 'Changes current featured character.';

  /**
   * Create a new command instance.
   *
   * @return void
   */
  public function __construct() {
    parent::__construct();
  }

  /**
   * Execute the console command.
   *
   * @return mixed
   */
  public function handle() {
    $id = Character::myo()->get()->random()->id;
    $setting = Settings::get('featured_character');
    while (
      $id == $setting
      || Character::find($id)['is_gift_art_allowed'] != 1
      || str_contains(Character::find($id)['slug'], 'NPC-')
    ) {
      $id = Character::myo()?->get()->random()->id;
    }
    DB::table('site_settings')->where('key', 'featured_character')->update(['value' => $id]);
  }
}
