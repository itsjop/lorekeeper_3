<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class AddSiteSettings extends Command {
  /**
   * The name and signature of the console command.
   *
   * @var string
   */
  protected $signature = 'add-site-settings';

  /**
   * The console command description.
   *
   * @var string
   */
  protected $description = 'Adds the default site settings.';

  /**
   * Create a new command instance.
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
    $this->info('*********************');
    $this->info('* ADD SITE SETTINGS *');
    $this->info('*********************' . "\n");

    $this->line("Adding site settings...existing entries will be skipped.\n");

    $this->addSiteSetting('is_registration_open', 0, '0: Registration closed,
1: Registration open. When registration is closed, invitation keys can still be used to register.');

    $this->addSiteSetting('transfer_cooldown', 0, 'Number of days to add to the cooldown timer when a character is transferred.');

    $this->addSiteSetting('open_transfers_queue', 0, '0: Character transfers do not need mod approval,
1: Transfers must be approved by a mod.');

    $this->addSiteSetting('is_prompts_open', 1, '0: New prompt submissions cannot be made (mods can work on the queue still),
1: Prompts are submittable.');

    $this->addSiteSetting('is_claims_open', 1, '0: New claims cannot be made (mods can work on the queue still),
1: Claims are submittable.');

    $this->addSiteSetting('is_reports_open', 1, '0: New reports cannot be made (mods can work on the queue still),
1: Reports are submittable.');

    $this->addSiteSetting('is_myos_open', 1, '0: MYO slots cannot be submitted for design approval,
1: MYO slots can be submitted for approval.');

    $this->addSiteSetting('is_design_updates_open', 1, '0: Characters cannot be submitted for design update approval,
1: Characters can be submitted for design update approval.');

    $this->addSiteSetting('blacklist_privacy', 0, 'Who can view the blacklist?
0: Admin only,
1: Staff only,
2: Members only,
3: Public.');

    $this->addSiteSetting('blacklist_link', 0, '0: No link to the blacklist is displayed anywhere,
1: Link to the blacklist is shown on the user list.');

    $this->addSiteSetting('blacklist_key', 0, 'Optional key to view the blacklist. Enter "0" to not require one.');

    $this->addSiteSetting('design_votes_needed', 3, 'Number of approval votes needed for a design update or MYO submission to be considered as having approval.');

    $this->addSiteSetting('admin_user', 1, 'ID of the site\'s admin user.');

    $this->addSiteSetting('gallery_submissions_open', 1, '0: Gallery submissions closed,
1: Gallery submissions open.');

    $this->addSiteSetting('gallery_rewards_divided', 1, '0: Gallery criteria rewards will be rewarded to each collaborator,
1: Gallery criteria rewards will be divided between collaborators.');

    $this->addSiteSetting('gallery_submissions_require_approval', 1, '0: Gallery submissions do not require approval,
1: Gallery submissions require approval.');

    $this->addSiteSetting('gallery_submissions_reward_currency', 0, '0: Gallery submissions do not reward currency,
1: Gallery submissions reward currency.');

    $this->addSiteSetting('group_currency', 1, 'ID of the group currency to award from gallery submissions (if enabled).');

    $this->addSiteSetting('character_title_display', 0, '0: Characters\' titles only display in their image info.
1: Characters\'s titles display alongside their category, species, rarity.');

    $this->addSiteSetting('character_title_display', 0, '0: Characters\' titles only display in their image info.
1: Characters\'s titles display alongside their category, species, rarity.');

    $this->addSiteSetting('is_maintenance_mode', 0, '0: Site is normal,
1: Users without the Has Maintenance Access power will be redirected to the home page.');

    //cultivation
    $this->addSiteSetting('cultivation_plot_usability', 0, 'Do plots become unusable once an item was cultivated? 0=no / 1=yes');
    $this->addSiteSetting('cultivation_care_cooldown', 0, 'How many plots can users care for each day? 0=unlimited.');
    $this->addSiteSetting('cultivation_area_unlock', 0, 'How many areas can a user unlock at the same time? 0=unlimited.');

    $this->addSiteSetting('featured_character', 1, 'ID of the currently featured character.');

    $this->addSiteSetting('claymore_cooldown', 0, 'Number of days to add to the cooldown timer when a pet/weapon/gear is attached.');

    $this->addSiteSetting('coupon_settings', 0, '0: Percentage is taken from total (e.g 20% from 2 items costing a total of 100 = 80),
1: Percentage is taken from item (e.g 20% from 2 items costing a total of 100 = 90)');

    $this->addSiteSetting('limited_stock_coupon_settings', 0, '0: Does not allow coupons to be used on limited stock items,
1: Allows coupons to be used on limited stock items');

    $this->addSiteSetting('shop_type', 0, '0: Default,
1: Collapsible.');

    $this->addSiteSetting('is_maintenance_mode', 0, '0: Site is normal,
1: Users without the Has Maintenance Access power will be redirected to the home page.');

    $this->addSiteSetting('discord_exp_multiplier', 1, '1 = default, anything past this will multiply accordingly.');

    $this->addSiteSetting('discord_level_notif', 1, '0: No level up notification,
1: DM notification,
2: Give user a notification of level up in channel.');

    $this->addSiteSetting('deactivated_privacy', 0, 'Who can view the deactivated list?
0: Admin only,
1: Staff only,
2: Members only,
3: Public.');

    $this->addSiteSetting('deactivated_link', 0, '0: No link to the deactivated list is displayed anywhere,
1: Link to the deactivated list is shown on the user list.');

    $this->addSiteSetting('deactivated_key', 0, 'Optional key to view the deactivated list. Enter "0" to not require one.');

    $this->addSiteSetting('comment_dislikes_enabled', 0, '0: Dislikes disabled,
1: Dislikes enabled.');

    $this->addSiteSetting('user_shop_limit', 1, 'Number of user shops that a user can make in total set to 0 to allow infinite shops.');

    $this->addSiteSetting('shop_type', 0, '0: Default,
1: Collapsible.');

    $this->addSiteSetting('coupon_settings', 0, '0: Percentage is taken from total (e.g 20% from 2 items costing a total of 100 = 80),
1: Percentage is taken from item (e.g 20% from 2 items costing a total of 100 = 90)');

    $this->addSiteSetting('limited_stock_coupon_settings', 0, '0: Does not allow coupons to be used on limited stock items,
1: Allows coupons to be used on limited stock items');

    $this->addSiteSetting('can_transfer_currency_directly', 1, 'Whether or not users can directly transfer currency to other users without trading.
0: Users cannot directly transfer currency.
1: Direct currency transfers are allowed.');

    $this->addSiteSetting('can_transfer_items_directly', 1, 'Whether or not users can directly transfer items to other users without trading.
0: Users cannot directly transfer items.
1: Direct item transfers are allowed.');

    $this->addSiteSetting('allow_users_to_delete_profile_comments', 0, '0: Users cannot delete profile comments,
1: Users can delete profile comments.');

    $this->addSiteSetting('trait_remover_needed', 0, '0: No item needed to remove traits via design update.
1: Trait Remover item needed to remove traits via design update.');
    $this->addSiteSetting('trait_per_item', 0, '0: One item unlocks x traits for selection, and x of them can be chosen.
1: One item unlocks x traits for selection, only one of them can be chosen.');
    $this->addSiteSetting('character_likes', 1, '0: Characters can be liked only once,
1: Characters can be liked daily.');
    $this->addSiteSetting('character_likes_leaderboard_enable', 1, '0: Disable leaderboard,
1: Enable leaderboard.');

    $this->addSiteSetting('encounter_energy', 5, 'Amount of energy for encounters a user should get each day. Resets daily.');

    $this->line("\nSite settings up to date!");
  }

  /**
   * Add a site setting.
   *
   * Example usage:
   * $this->addSiteSetting("site_setting_key", 1, "0: does nothing.
   * 1: does something.");
   *
   * @param string $key
   * @param int    $value
   * @param string $description
   */
  private function addSiteSetting($key, $value, $description) {
    if (!DB::table('site_settings')->where('key', $key)->exists()) {
      DB::table('site_settings')->insert([
        [
          'key'         => $key,
          'value'       => $value,
          'description' => $description,
        ],
      ]);
      $this->info('Added:   ' . $key . ' / Default: ' . $value);
    } else {
      $this->line('Skipped: ' . $key);
    }
  }
}
